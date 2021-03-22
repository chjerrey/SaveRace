<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Charts using XML & AJAX</h1>
<div id="chartContainer"></div>

<script>
var dataPoints = []; 

$.get("/api/datapoints.php?xstart=5&ystart=10&length=10&type=xml", function(data) {
    $(data).find("point").each(function () {
            var $dataPoint = $(this);
            var x = $dataPoint.find("x").text();
            var y = $dataPoint.find("y").text();
            dataPoints.push({x: parseFloat(x), y: parseFloat(y)});
    });

    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        animationEnabled: true,
            title: {
                text: "CanvasJS Charts in PHP using XML & AJAX",
            },
            data: [{
                 type: "line",
                 dataPoints: dataPoints,
              }]
    });
chart.render();
});
</script>

<?php include '../footer.php'; ?>