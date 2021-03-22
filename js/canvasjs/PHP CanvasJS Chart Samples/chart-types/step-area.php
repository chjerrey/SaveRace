<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Step Area Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 1293820200000, "y" => 89.28),
	array("x" => 1296498600000, "y" => 85.53),
	array("x" => 1298917800000, "y" => 98.66),
	array("x" => 1301596200000, "y" => 105.72),
	array("x" => 1304188200000, "y" => 95.72),
	array("x" => 1306866600000, "y" => 90.67),
	array("x" => 1309458600000, "y" => 91.51),
	array("x" => 1312137000000, "y" => 79.86),
	array("x" => 1314815400000, "y" => 79.31),
	array("x" => 1317407400000, "y" => 80.19),
	array("x" => 1320085800000, "y" => 91.34),
	array("x" => 1322677800000, "y" => 93.14),
	array("x" => 1325356200000, "y" => 94.18),
	array("x" => 1328034600000, "y" => 96.17),
	array("x" => 1330540200000, "y" => 99.49),
	array("x" => 1333218600000, "y" => 96.22),
	array("x" => 1335810600000, "y" => 87.31),
	array("x" => 1338489000000, "y" => 75.4),
	array("x" => 1341081000000, "y" => 80.93),
	array("x" => 1343759400000, "y" => 88.04),
	array("x" => 1346437800000, "y" => 88.41),
	array("x" => 1349029800000, "y" => 83.06),
	array("x" => 1351708200000, "y" => 80.55),
	array("x" => 1354300200000, "y" => 82.35),
	array("x" => 1356978600000, "y" => 88.6),
	array("x" => 1359657000000, "y" => 86.48),
	array("x" => 1362076200000, "y" => 87.5)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {

            animationEnabled: true,
            zoomEnabled: true,
            title: {
                text: "Monthly Average Crude Oil Prices"
            },
            legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
            },
            axisX: {
                valueFormatString: "MMM YY"
            },
            axisY: {
                includeZero: false,
                prefix: "$",
                title: "Inflation Adjusted Price",
                maximum: 110
            },
            data: [
            {
                type: "stepArea",
                markerSize: 0,
                toolTipContent: "{x} : <strong>${y} <strong>",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>