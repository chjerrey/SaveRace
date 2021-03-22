<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Charts using JSON & AJAX</h1>
<div id="chartContainer" style="height: 400px; width: 100%;"></div>

<script type="text/javascript">
    $(document).ready(function () {

        $.get("/api/datapoints.php?xstart=5&ystart=10&length=50&type=json", function (data) {
            var dataPoints = [];
            $.each(data, function(key, value){
                dataPoints.push({x: value[0], y: value[1]});    
            });
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",//light1
                title: {
                    text: "CanvasJS Charts in PHP using JSON & AJAX"
                },
                data: [
                {
                    // Change type to "bar", "splineArea", "area", "spline", "pie",etc.
                    type: "line",
                    dataPoints: dataPoints
                    }
                ]
            });

            chart.render();
        });

    });
</script>

<?php include '../footer.php'; ?>