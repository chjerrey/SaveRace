<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Sync Multiple Charts</h1>
<div id="chartContainer1" style="height: 400px; width: 100%;"></div>
<div id="chartContainer2" style="height: 400px; width: 100%;"></div>

<script type="text/javascript">

    $(function () {        
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            zoomEnabled: true,
            zoomType: "x",
            title: {
                text: "Chart1 - Try Zooming / Panning"
            },
            data: [{
                type: "line",

                dataPoints: []
            }],
            rangeChanged: syncHandler
        });
        
        //-------- Chart 2 ---------------
        var chart2 = new CanvasJS.Chart("chartContainer2", {
            zoomEnabled: true,
            zoomType: "x",
            title: {
                text: "Chart2 - Try Zooming / Panning"
            },
            data: [{
                type: "line",

                dataPoints: []
            }],
            rangeChanged: syncHandler
        });
        
        jQuery.getJSON("/api/datapoints.php?xstart=5&ystart=10&length=50&type=json", function(data){
            var dataPoints = [];
            $.each(data, function(key, value){
                dataPoints.push({x: value[0], y: value[1]});    
            });
            chart1.options.data[0].dataPoints = dataPoints;
            chart1.render(); 
        });        
        
        jQuery.getJSON("/api/datapoints.php?xstart=5&ystart=10&length=50&type=json", function(data){
            var dataPoints = [];
            $.each(data, function(key, value){
                dataPoints.push({x: value[0], y: value[1]});    
            });
            chart2.options.data[0].dataPoints = dataPoints;
            chart2.render();
        });
        

        //--------------------Sync Chart-------------------
        var charts = [chart1, chart2];

        function syncHandler(e) {

            for (var i = 0; i < charts.length; i++) {
                var chart = charts[i];

                if (!chart.options.axisX) chart.options.axisX = {};
                if (!chart.options.axisY) chart.options.axisY = {};

                if (e.trigger === "reset") {

                    chart.options.axisX.viewportMinimum = chart.options.axisX.viewportMaximum = null;
                    chart.options.axisY.viewportMinimum = chart.options.axisY.viewportMaximum = null;
                    chart.render();
                } else if (chart !== e.chart) {

                    chart.options.axisX.viewportMinimum = e.axisX[0].viewportMinimum;
                    chart.options.axisX.viewportMaximum = e.axisX[0].viewportMaximum;

                    chart.options.axisY.viewportMinimum = e.axisY[0].viewportMinimum;
                    chart.options.axisY.viewportMaximum = e.axisY[0].viewportMaximum;
                    chart.render();
                }



            }
        }
    });
</script>

<?php include '../footer.php'; ?>