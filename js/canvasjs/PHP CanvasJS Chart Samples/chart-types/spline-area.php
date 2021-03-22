<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Spline Area Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 694204200000, "y" => 2506000),
	array("x" => 725826600000, "y" => 2798000),
	array("x" => 757362600000, "y" => 3386000),
	array("x" => 788898600000, "y" => 6944000),
	array("x" => 820434600000, "y" => 6026000),
	array("x" => 852057000000, "y" => 2394000),
	array("x" => 883593000000, "y" => 1872000),
	array("x" => 915129000000, "y" => 2140000),
	array("x" => 946665000000, "y" => 7289000),
	array("x" => 978287400000, "y" => 4830000),
	array("x" => 1009823400000, "y" => 2009000),
	array("x" => 1041359400000, "y" => 2840000),
	array("x" => 1072895400000, "y" => 2396000),
	array("x" => 1104517800000, "y" => 1613000),
	array("x" => 1136053800000, "y" => 2821000),
	array("x" => 1167589800000, "y" => 2000000),
	array("x" => 1199125800000, "y" => 1397000)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Music Album Sales by Year"
            },
            animationEnabled: true,
            axisY: {
                title: "Units Sold",
                valueFormatString: "#0,,.",
                suffix: " m"
            },
            data: [
			{
			    toolTipContent: "{y} units",
			    type: "splineArea",
			    markerSize: 5,
			    color: "rgba(54,158,173,.7)",
                            xValueType: "dateTime",
			    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
			}
            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>