<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Bubble Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 78.1, "y" => 2, "z" => 306.77, "name" => "US"),
	array("x" => 68.5, "y" => 2.15, "z" => 237.414, "name" => "Indonesia"),
	array("x" => 72.5, "y" => 1.86, "z" => 193.24, "name" => "Brazil"),
	array("x" => 76.5, "y" => 2.36, "z" => 112.24, "name" => "Mexico"),
	array("x" => 50.9, "y" => 5.56, "z" => 154.48, "name" => "Nigeria"),
	array("x" => 68.6, "y" => 1.54, "z" => 141.91, "name" => "Russia"),
	array("x" => 82.9, "y" => 1.37, "z" => 127.55, "name" => "Japan"),
	array("x" => 79.8, "y" => 1.36, "z" => 81.9, "name" => "Australia"),
	array("x" => 72.7, "y" => 2.78, "z" => 79.71, "name" => "Egypt"),
	array("x" => 80.1, "y" => 1.94, "z" => 61.81, "name" => "UK"),
	array("x" => 55.8, "y" => 4.76, "z" => 39.24, "name" => "Kenya"),
	array("x" => 81.5, "y" => 1.93, "z" => 21.95, "name" => "Australia"),
	array("x" => 68.1, "y" => 4.77, "z" => 31.09, "name" => "Iraq"),
	array("x" => 47.9, "y" => 6.42, "z" => 33.42, "name" => "Afganistan"),
	array("x" => 50.3, "y" => 5.58, "z" => 18.55, "name" => "Angola")
    );
?>

<script type="text/javascript">

    $(function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            zoomEnabled: true,
            animationEnabled: true,
            title: {
                text: "Fertility Rate Vs Life Expectancy in different countries - 2009"
            },
            subtitles: [
                {
                    text: "Try Zooming and Panning"
                }
            ],
            axisX: {
                title: "Life Expectancy",
                maximum: 85
            },
            axisY: {
                title: "Fertility Rate"

            },

            legend: {
                verticalAlign: "bottom",
                horizontalAlign: "left"

            },
            data: [
            {
                type: "bubble",
                legendText: "Size of Bubble Represents Population",
                showInLegend: true,
                legendMarkerType: "circle",
                legendMarkerColor: "grey",
                toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong></span><br/><strong>Life Exp</strong> {x} yrs<br/> <strong>Fertility Rate</strong> {y}<br/> <strong>Population</strong> {z}mn",

                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>