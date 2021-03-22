<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Line Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("x" => 10, "y" => 71),
	array("x" => 20, "y" => 55),
	array("x" => 30, "y" => 50),
	array("x" => 40, "y" => 65),
	array("x" => 50, "y" => 95),
	array("x" => 60, "y" => 68),
	array("x" => 70, "y" => 28),
	array("x" => 80, "y" => 34),
	array("x" => 90, "y" => 14),
	array("x" => 100, "y" => 33),
	array("x" => 110, "y" => 42),
	array("x" => 120, "y" => 62),
	array("x" => 130, "y" => 70),
	array("x" => 140, "y" => 85),
	array("x" => 150, "y" => 58),
	array("x" => 160, "y" => 34),
	array("x" => 170, "y" => 24),
	array("x" => 180, "y" => 33),
	array("x" => 190, "y" => 28),
	array("x" => 200, "y" => 42)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            zoomEnabled: true,
            animationEnabled: true,
            title: {
                text: "Line Chart in PHP using CanvasJS"
            },
            subtitles: [
                {
                    text: "Try Zooming and Panning"
                }
            ],
            data: [
            {
                type: "line",

                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>