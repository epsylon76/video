<script id="source" language="javascript" type="text/javascript">
       $(document).ready(function() {
           var renderInterfaceGraph = function (interfaceName) {
               var options = {
                   lines: { show: true },
                   points: { show: true },
                   xaxis: { mode: "time" }
               };
               var data = [];
               var placeholderName = "placeholder_" + interfaceName;
               var html = "<div id=\"" + placeholderName + "\" style=\"height:300px;\"></div>";
               var placeholder = $(html);
               placeholder.appendTo($('#graph'));
               $.plot(placeholder, data, options);
               var iteration = 0;
               function fetchData() {
                   ++iteration;
                   function onDataReceived(series) {
                       // we get all the data in one go, if we only got partial
                       // data, we could merge it with what we already got
                       data = [ series ];
                       $.plot(placeholder, data, options);
                   }
                   $.ajax({
                       url: "./scripts/data_graph.php?interface=" + interfaceName,
                       method: 'GET',
                       dataType: 'json',
                       success: onDataReceived
                   });
                   setTimeout(fetchData, 1000);
               }
               fetchData();
           };
           renderInterfaceGraph('<?php echo $params['net_iface']; ?>');
       });
       </script>
