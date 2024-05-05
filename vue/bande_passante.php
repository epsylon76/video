<script src="/includes/js/chartjs/dist/chart.umd.js" type="text/javascript"></script>


<div class="container">
    <h1>Utilisation de la bande passante</h1>
    <div style="width: 900px;">
        <canvas id="chart"></canvas>
    </div>

    <button type="button" id="convert" class="btn btn-secondary" data-state="mbps">En Mbps</button>
</div>



<script>
    $(document).ready(function() {
        //recuperer l'état initial du bouton
        var state = $('#convert').data('state');
        var maChart;

        function initChart(data) {
            maChart = new Chart(
                document.getElementById('chart'), {
                    type: 'bar',
                    data: {
                        labels: data.map(row => row.periode),
                        datasets: [{
                                label: 'Dl vidéo',
                                data: data.map(row => row.dl_video),
                                backgroundColor: '#eb4d4b',
                            },
                            {
                                label: 'Lecture vidéo',
                                data: data.map(row => row.play_videos),
                                backgroundColor: '#f0932b',
                            },
                            {
                                label: 'Diapo photo',
                                data: data.map(row => row.defile_photo),
                                backgroundColor: '#f9ca24',
                            },
                            {
                                label: 'Dl photos',
                                data: data.map(row => row.dl_photos),
                                backgroundColor: '#f6e58d',
                            }
                        ]
                    },
                    options: {
                        animations: {
                            tension: {
                                duration: 1000,
                                easing: 'linear',
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true
                            }
                        }
                    }
                });
        }

        function updateChart(newdata) {
            console.log(newdata);
            maChart.data.datasets[0].data = newdata.map(row => row.dl_video);
            maChart.data.datasets[1].data = newdata.map(row => row.play_videos);
            maChart.data.datasets[2].data = newdata.map(row => row.defile_photo);
            maChart.data.datasets[3].data = newdata.map(row => row.dl_photos);
            maChart.update();
        }

        $.ajax({
            url: '/ajax/ajax_chart.php',
            type: 'POST',
            data: {
                'state': state
            },
            dataType: 'json',
            success: function(response) {
                initChart(response);
            },
        });

        $('#convert').on('click', function() {
            var btn = $(this);
            var state = $('#convert').data('state');
            
            //on inverse le texte et l'etat
            if (state == 'mbps') {
                state = 'go';
                btn.data('state', 'go');
                btn.text('En Go');
            } else {
                state = 'mbps';
                btn.data('state', 'mbps');
                btn.text('En Mbps');
            }

            $.ajax({
                url: '/ajax/ajax_chart.php',
                type: 'POST',
                data: {
                    'state': state
                },
                dataType: 'json',
                success: function(response) {
                    updateChart(response);
                }
            });
        });

    });
</script>