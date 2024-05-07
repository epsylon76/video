<script src="/includes/js/chartjs/dist/chart.umd.js" type="text/javascript"></script>


<div class="container">
    <h1>Utilisation de la bande passante</h1>
    <div style="width: 900px;">
        <canvas id="chart"></canvas>
    </div>

    <div>
        <button type="button" id="btn_heure1" class="btn btn-secondary btn_heure" data-heure="6">6H</button>
        <button type="button" id="btn_heure2" class="btn btn-secondary btn_heure" data-heure="12">12H</button>
        <button type="button" id="btn_heure3" class="btn btn-secondary btn_heure" data-heure="24">24H</button>
    </div>

    <br>

    <button type="button" id="convert" class="btn btn-secondary" data-state="mbps">En Mbps</button>
</div>



<script>
    $(document).ready(function() {
        //recuperer l'état initial du bouton
        var state = $('#convert').data('state');
        var maChart; // déclarer la variable avant pour la rendre disponible globalement

        //
        // Partie initialisation
        //

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

        //
        // Partie mise à jour
        //

        function updateChart(newdata) {
            console.log(newdata);
            maChart.data.datasets[0].data = newdata.map(row => row.dl_video); //chaque dataset = un type
            maChart.data.datasets[1].data = newdata.map(row => row.play_videos);
            maChart.data.datasets[2].data = newdata.map(row => row.defile_photo);
            maChart.data.datasets[3].data = newdata.map(row => row.dl_photos);
            maChart.data.labels = newdata.map(row => row.periode);
            maChart.update();
        }


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

            //On rtécupère les nouvelles données
            
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



        $('#btn_heure1').on('click', function() {
            var heure = $('#btn_heure1').data('heure');
            var state = $('#convert').data('state');
            
            $.ajax({
                url: '/ajax/ajax_chart.php',
                type: 'POST',
                data: {
                    'heure': heure ,'state' : state
                },
                dataType: 'json',
                success: function(response) {
                    updateChart(response);
                }
            });
        });
        $('#btn_heure2').on('click', function() { 
            var heure = $('#btn_heure2').data('heure');
            var state = $('#convert').data('state');
        
            $.ajax({
                url: '/ajax/ajax_chart.php',
                type: 'POST',
                data: {
                    'heure': heure, 'state' : state
                },
                dataType: 'json',
                success: function(response) {
                    updateChart(response);
                }
            });
        });
        $('#btn_heure3').on('click', function() {
            var heure = $('#btn_heure3').data('heure');
            var state = $('#convert').data('state');
            
            $.ajax({
                url: '/ajax/ajax_chart.php',
                type: 'POST',
                data: {
                    'heure': heure, 'state' : state
                },
                dataType: 'json',
                success: function(response) {
                    updateChart(response);
                }
            });
        });

    });
</script>