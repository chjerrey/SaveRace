<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Area Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 1325356200000, "y" => 2600),
	array("x" => 1328034600000, "y" => 3800),
	array("x" => 1330540200000, "y" => 4300),
	array("x" => 1333218600000, "y" => 2900),
	array("x" => 1335810600000, "y" => 4100),
	array("x" => 1338489000000, "y" => 4500),
	array("x" => 1341081000000, "y" => 8600),
	array("x" => 1343759400000, "y" => 6400),
	array("x" => 1346437800000, "y" => 5300),
	array("x" => 1349029800000, "y" => 6000)
    );

?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Monthly Downloads",
                fontSize: 25
            },
            axisX: {
                valueFormatString: "MMM",
                interval: 1,
                intervalType: "month"

            },
            axisY: {
                title: "Downloads"
            },

            data: [
            {
                type: "area",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints); ?>
            }
            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>