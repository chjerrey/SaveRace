<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Scatter Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 800, "y" => 350),
	array("x" => 900, "y" => 450),
	array("x" => 850, "y" => 450),
	array("x" => 1250, "y" => 700),
	array("x" => 1100, "y" => 650),
	array("x" => 1350, "y" => 850),
	array("x" => 1200, "y" => 900),
	array("x" => 1410, "y" => 1250),
	array("x" => 1250, "y" => 1100),
	array("x" => 1400, "y" => 1150),
	array("x" => 1500, "y" => 1050),
	array("x" => 1330, "y" => 1120),
	array("x" => 1580, "y" => 1220),
	array("x" => 1620, "y" => 1400),
	array("x" => 1250, "y" => 1450),
	array("x" => 1350, "y" => 1600),
	array("x" => 1650, "y" => 1300),
	array("x" => 1700, "y" => 1620),
	array("x" => 1750, "y" => 1700),
	array("x" => 1830, "y" => 1800),
	array("x" => 1900, "y" => 2000),
	array("x" => 2050, "y" => 2200),
	array("x" => 2150, "y" => 1960),
	array("x" => 2250, "y" => 1990)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            zoomEnabled: true,
            zoomType: "xy",
            title: {
                text: "Real Estate Rates"
            },
            subtitles: [
                {
                    text: "Try Zooming and Panning"
                }
            ],
            animationEnabled: true,
            axisX: {
                title: "Square Feets"
            },
            axisY: {
                title: "Prices in USD",
                valueFormatString: "$#,##0k",
                lineThickness: 2,
                includeZero: false
            },
            data: [
			{
			    type: "scatter",
			    toolTipContent: "<span style='\"'color: {color};'\"'><strong>Area: </strong></span>{x} sq.ft<br/><span style='\"'color: {color};'\"'><strong>Price: </strong></span>{y} $ ",

			    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
			}]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>