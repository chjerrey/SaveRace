<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Step Line Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 1325356200000, "y" => 8.3),
	array("x" => 1328034600000, "y" => 8.3),
	array("x" => 1330540200000, "y" => 8.2),
	array("x" => 1333218600000, "y" => 8.1),
	array("x" => 1335810600000, "y" => 8.2),
	array("x" => 1338489000000, "y" => 8.2),
	array("x" => 1341081000000, "y" => 8.2),
	array("x" => 1343759400000, "y" => 8.1),
	array("x" => 1346437800000, "y" => 7.8),
	array("x" => 1349029800000, "y" => 7.9),
	array("x" => 1351708200000, "y" => 7.8),
	array("x" => 1354300200000, "y" => 7.8),
	array("x" => 1356978600000, "y" => 7.9),
	array("x" => 1359657000000, "y" => 7.7),
	array("x" => 1362076200000, "y" => 7.6),
	array("x" => 1364754600000, "y" => 7.5)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "US Unemployement Rate"
            },
            animationEnabled: true,
            axisX: {
                valueFormatString: "MMM YY"
            },
            axisY: {
                includeZero: false,
                interval: .25,
                valueFormatString: "#.00'%'"
            },

            data: [
            {
                type: "stepLine",
                toolTipContent: "{x}: {y}%",
                markerSize: 5,
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }

            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>