
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Parse the JSON data passed from the controller
            var data = google.visualization.arrayToDataTable({!! isset($chartData) ? $chartData : '[]' !!});

            var options = {
                title: 'Expenses',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>


    <div id="piechart_3d" style="width: 800px; height: 600px;"></div>



