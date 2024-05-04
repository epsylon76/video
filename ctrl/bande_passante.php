<?php
include('vue/bande_passante.php');

$liste_stats = $stats->get_stats('2024-04-30 17:11:39', '2024-04-30 17:20:39');

foreach($liste_stats as $row){
    // $heure = $row['heure'];
    // $heure_formattee = date('H:', strtotime($heure)) . str_pad(floor(date('i', strtotime($heure)) / 10) * 10, 2, '0', STR_PAD_LEFT);


    // pr ($heure_formattee);
    pr($row);
}




?>

<script>
$(document).ready(function() {

    var maChart;

    function initChart(data) {
        maChart = new Chart(
            document.getElementById('chart'),
            {
                type: 'bar',
                data: {
                    labels: data.map(row => row.periode),
                    datasets: [{
                        label: 'En Go',
                        data: data.map(row => row.total_taille),
                        backgroundColor: '#3274E6',
                    }]
                },
                options: {
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                        }
                    }
                }   
            }
        );
    }

    function updateChart(data, labelName) {
        maChart.data.labels = data.map(row => row.periode);
        maChart.data.datasets[0].data = data.map(row => row.total_taille);
        maChart.data.datasets[0].label = labelName;
        maChart.update();
    }

    $.ajax({
        url: '/ajax/ajax_chart.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            initChart(response);
        },
    });

    $('#convert').on('click', function() {
        var btn = $(this);
        var clicked = btn.data('clicked');

        clicked = !clicked;

        btn.data('clicked', clicked);

        if (clicked) {
            btn.text("En Gbps"); 
        } else {
            btn.text("En Go"); 
        }

        $.ajax({
            url: '/ajax/ajax_chart.php',
            type: 'POST',
            data: {'clicked': clicked},
            dataType: 'json',
            success: function(response) {
                updateChart(response, btn.text());
            }
        });
    });
});


</script>