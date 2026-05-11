<?php
include_once(__DIR__ . '/../mdl/stats.php');
include(__DIR__ . '/../config/dbconn.php');
include(__DIR__ . '/../config/fonctions.php');

$stats = new stats();

$type_config = array(
    'dl_video' => array('label' => 'Dl vidéo', 'color' => '#2563eb'),
    'play_videos' => array('label' => 'Lecture vidéo', 'color' => '#16a34a'),
    'dl_photos' => array('label' => 'Dl photos', 'color' => '#f59e0b'),
    'defile_photo' => array('label' => 'Diapo photo', 'color' => '#db2777'),
);

function bytes_to_human($bytes)
{
    $bytes = (float) $bytes;
    $units = array('o', 'Ko', 'Mo', 'Go', 'To');
    $index = 0;
    while ($bytes >= 1024 && $index < count($units) - 1) {
        $bytes /= 1024;
        $index++;
    }
    return round($bytes, $index === 0 ? 0 : 1) . ' ' . $units[$index];
}

function metric_value($mode, $volume, $actions, $bucket_seconds)
{
    $volume = (float) $volume;
    $actions = (int) $actions;

    if ($mode === 'actions') {
        return $actions;
    }
    if ($mode === 'average') {
        return $actions > 0 ? $volume / $actions / 1024 / 1024 : 0;
    }
    if ($mode === 'volume') {
        return $volume / 1024 / 1024 / 1024;
    }
    return $bucket_seconds > 0 ? $volume * 8 / 1000000 / $bucket_seconds : 0;
}

function metric_label($mode)
{
    if ($mode === 'actions') {
        return 'Actions';
    }
    if ($mode === 'average') {
        return 'Mo/action';
    }
    if ($mode === 'volume') {
        return 'Go';
    }
    return 'Mbps';
}

function date_range_for_period($period)
{
    $now = time();
    $end = $now;

    switch ($period) {
        case '6h':
            return array($end - 6 * 3600, $end, 'minute', 600);
        case '12h':
            return array($end - 12 * 3600, $end, 'minute', 600);
        case '7d':
            return array($end - 7 * 86400, $end, 'hour', 3600);
        case '30d':
            return array($end - 30 * 86400, $end, 'day', 86400);
        case '12w':
            return array($end - 12 * 7 * 86400, $end, 'week', 7 * 86400);
        case 'all':
            return array(strtotime('2024-04-30 00:00:00'), $end, 'week', 7 * 86400);
        case '24h':
        default:
            return array($end - 24 * 3600, $end, 'minute', 600);
    }
}

function period_label($timestamp, $bucket)
{
    if ($bucket === 'minute') {
        return date('H:i', $timestamp);
    }
    if ($bucket === 'hour') {
        return date('d/m H\h', $timestamp);
    }
    if ($bucket === 'day') {
        return date('d/m', $timestamp);
    }
    return 'S' . date('W Y', $timestamp);
}

function period_key($timestamp, $bucket)
{
    if ($bucket === 'minute' || $bucket === 'hour') {
        return date('Y-m-d H:i:00', $timestamp);
    }
    if ($bucket === 'day') {
        return date('Y-m-d', $timestamp);
    }
    return date('Y-m-d', strtotime('monday this week', $timestamp));
}

$allowed_periods = array('6h', '12h', '24h', '7d', '30d', '12w', 'all');
$period = isset($_POST['period']) && in_array($_POST['period'], $allowed_periods, true) ? $_POST['period'] : '24h';
if (isset($_POST['heure']) && !isset($_POST['period'])) {
    $legacy_period = (int) $_POST['heure'] . 'h';
    if (in_array($legacy_period, $allowed_periods, true)) {
        $period = $legacy_period;
    }
}

$allowed_modes = array('mbps', 'volume', 'actions', 'average');
$mode = isset($_POST['mode']) && in_array($_POST['mode'], $allowed_modes, true) ? $_POST['mode'] : 'mbps';
if (isset($_POST['state']) && !isset($_POST['mode'])) {
    $mode = $_POST['state'] === 'go' ? 'volume' : 'mbps';
}

$available_rows = $stats->get_available_types();
$available_types = array();
foreach ($available_rows as $row) {
    if (isset($type_config[$row['type']])) {
        $available_types[] = $row['type'];
    }
}
if (empty($available_types)) {
    $available_types = array_keys($type_config);
}

$selected_types = $available_types;
if (isset($_POST['types']) && is_array($_POST['types'])) {
    $selected_types = array_values(array_intersect($_POST['types'], $available_types));
    if (empty($selected_types)) {
        $selected_types = $available_types;
    }
}

list($start_timestamp, $end_timestamp, $bucket, $bucket_seconds) = date_range_for_period($period);
if ($bucket === 'minute') {
    $end_timestamp = (int) (ceil($end_timestamp / $bucket_seconds) * $bucket_seconds);
    $start_timestamp = (int) (floor($start_timestamp / $bucket_seconds) * $bucket_seconds);
}

$date_debut = date('Y-m-d H:i:00', $start_timestamp);
$date_fin = date('Y-m-d H:i:00', $end_timestamp);

$rows = $stats->get_stats_by_bucket($date_debut, $date_fin, $bucket, $bucket_seconds, $selected_types);
$summary_rows = $stats->get_summary($date_debut, $date_fin, $selected_types);
$type_summary_rows = $stats->get_summary($date_debut, $date_fin, $available_types);
$top_days_rows = $stats->get_top_days($date_debut, $date_fin, $selected_types, 10);
$hourly_rows = $stats->get_hourly_distribution($date_debut, $date_fin, $selected_types);

$by_period = array();
foreach ($rows as $row) {
    $key = $bucket === 'minute' || $bucket === 'hour'
        ? date('Y-m-d H:i:00', strtotime($row['periode']))
        : date('Y-m-d', strtotime($row['periode']));
    $by_period[$key][$row['type']] = array(
        'volume' => (float) $row['volume'],
        'actions' => (int) $row['actions'],
    );
}

$series = array();
$peak_value = 0;
$peak_label = '';
for ($timestamp = $start_timestamp; $timestamp < $end_timestamp; $timestamp += $bucket_seconds) {
    $key = period_key($timestamp, $bucket);
    $line = array(
        'periode' => period_label($timestamp, $bucket),
        'raw_period' => $key,
        'total' => 0,
        'total_volume' => 0,
        'total_actions' => 0,
    );

    foreach ($selected_types as $type) {
        $volume = isset($by_period[$key][$type]) ? $by_period[$key][$type]['volume'] : 0;
        $actions = isset($by_period[$key][$type]) ? $by_period[$key][$type]['actions'] : 0;
        $value = metric_value($mode, $volume, $actions, $bucket_seconds);

        $line[$type] = $value;
        $line[$type . '_volume'] = $volume;
        $line[$type . '_actions'] = $actions;
        $line['total_volume'] += $volume;
        $line['total_actions'] += $actions;
    }

    $line['total'] = metric_value($mode, $line['total_volume'], $line['total_actions'], $bucket_seconds);
    if ($line['total'] > $peak_value) {
        $peak_value = $line['total'];
        $peak_label = $line['periode'];
    }
    $series[] = $line;

    if ($bucket === 'week') {
        $timestamp = strtotime('+1 week', strtotime($key)) - $bucket_seconds;
    }
}

$type_summary = array();
foreach ($type_summary_rows as $row) {
    $type_summary[$row['type']] = array(
        'volume' => (float) $row['volume'],
        'actions' => (int) $row['actions'],
    );
}

$types = array();
$total_volume = 0;
$total_actions = 0;
$top_type = null;
foreach ($summary_rows as $row) {
    $type = $row['type'];
    if (!isset($type_config[$type])) {
        continue;
    }
    $volume = (float) $row['volume'];
    $actions = (int) $row['actions'];
    $total_volume += $volume;
    $total_actions += $actions;
    if ($top_type === null || $volume > $top_type['volume']) {
        $top_type = array(
            'key' => $type,
            'label' => $type_config[$type]['label'],
            'volume' => $volume,
        );
    }
}

foreach ($available_types as $type) {
    if (!isset($type_config[$type])) {
        continue;
    }

    $volume = isset($type_summary[$type]) ? $type_summary[$type]['volume'] : 0;
    $actions = isset($type_summary[$type]) ? $type_summary[$type]['actions'] : 0;

    $types[] = array(
        'key' => $type,
        'label' => $type_config[$type]['label'],
        'color' => $type_config[$type]['color'],
        'volume' => $volume,
        'volume_human' => bytes_to_human($volume),
        'actions' => $actions,
        'average_human' => $actions > 0 ? bytes_to_human($volume / $actions) : '0 o',
        'selected' => in_array($type, $selected_types, true),
    );
}

$top_days = array();
foreach ($top_days_rows as $row) {
    $top_days[] = array(
        'jour' => date('d/m/Y', strtotime($row['jour'])),
        'volume' => (float) $row['volume'],
        'volume_human' => bytes_to_human($row['volume']),
        'actions' => (int) $row['actions'],
    );
}

$hourly_map = array();
foreach ($hourly_rows as $row) {
    $hourly_map[(int) $row['hour']] = array(
        'hour' => (int) $row['hour'],
        'volume' => (float) $row['volume'],
        'actions' => (int) $row['actions'],
    );
}
$hourly = array();
for ($hour = 0; $hour < 24; $hour++) {
    $volume = isset($hourly_map[$hour]) ? $hourly_map[$hour]['volume'] : 0;
    $actions = isset($hourly_map[$hour]) ? $hourly_map[$hour]['actions'] : 0;
    $hourly[] = array(
        'hour' => $hour,
        'label' => str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . 'h',
        'value' => metric_value($mode, $volume, $actions, 3600),
        'volume_human' => bytes_to_human($volume),
        'actions' => $actions,
    );
}

$response = array(
    'meta' => array(
        'period' => $period,
        'mode' => $mode,
        'unit' => metric_label($mode),
        'bucket' => $bucket,
        'bucket_seconds' => $bucket_seconds,
        'date_start' => $date_debut,
        'date_end' => $date_fin,
    ),
    'summary' => array(
        'volume' => $total_volume,
        'volume_human' => bytes_to_human($total_volume),
        'actions' => $total_actions,
        'average_human' => $total_actions > 0 ? bytes_to_human($total_volume / $total_actions) : '0 o',
        'peak_value' => round($peak_value, 2),
        'peak_label' => $peak_label,
        'top_type' => $top_type,
    ),
    'types' => $types,
    'series' => $series,
    'top_days' => $top_days,
    'hourly' => $hourly,
);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
?>
