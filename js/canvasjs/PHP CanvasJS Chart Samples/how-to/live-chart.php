<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Dynamic / Live Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 1, "y" => 10),
	array("x" => 2, "y" => 13),
	array("x" => 3, "y" => 18),
	array("x" => 4, "y" => 20),
	array("x" => 5, "y" => 17),
	array("x" => 6, "y" => 10),
	array("x" => 7, "y" => 13),
	array("x" => 8, "y" => 18),
	array("x" => 9, "y" => 20),
	array("x" => 10, "y" => 17)
    );
    
?>

<script type="text/javascript">

    $(function () {
        var dps = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;   //dataPoints.

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Line Chart with Live Data"
            },
            data: [{
                type: "line",
                dataPoints: dps
            }]
        });

        chart.render();

        var xVal = dps.length + 1;
        var yVal = 15;
        var updateInterval = 500;

        var updateChart = function () {
            yVal = yVal + Math.round(5 + Math.random() * (-5 - 5));
            dps.push({ x: xVal, y: yVal });
            xVal++;

            chart.render();
        };
        setInterval(function () { updateChart() }, updateInterval);
    });
</script>

<?php include '../footer.php'; ?>