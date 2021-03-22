<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Render Chart on Button Click</h1>
<div id="chartContainer" style="height: 400px; width: 100%;"></div>
<br />
<div style="margin-left:30%">
    <button id="StartButton" class="btn btn-success" type="submit" value="Start">Start Live Chart</button>
    <button id="StopButton" class="btn btn-danger" type="submit" value="Stop">Stop Live Chart</button>
</div>

<?php
    $dataPoints = array(
	array("x" => 1, "y" => 15),
	array("x" => 2, "y" => 20),
	array("x" => 3, "y" => 18),
	array("x" => 4, "y" => 22),
	array("x" => 5, "y" => 20)
    );
    
?>

<script type="text/javascript">

    $(function () {
        var dps = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>   //dataPoints.

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Live Chart with Start/Stop Controls"
            },
            axisY: {
                title: "Units"
            },
            data: [{
                type: "spline",
                dataPoints: dps
            }]
        });

        chart.render();

        // Updating the Chart
        var xVal = dps.length + 1;
        var yVal = 20;
        var updateInterval = 500;

        var updateChart = function () {
            yVal = yVal + Math.round(5 + Math.random() * (-5 - 5));
            dps.push({ x: xVal, y: yVal });
            xVal++;
            chart.render();
        };


        var timeoutId;

        function startLiveChart() {
            timeoutId = setInterval(function () { updateChart() }, updateInterval);
            $('#StartButton').unbind('click', startLiveChart);
            $('#StopButton').bind('click', stopLiveChart);
        }

        function stopLiveChart() {
            clearTimeout(timeoutId);
            $('#StopButton').unbind('click', stopLiveChart);
            $('#StartButton').bind('click', startLiveChart);
        }

        $('#StartButton').bind('click', startLiveChart);


    });
</script>

<?php include '../footer.php'; ?>