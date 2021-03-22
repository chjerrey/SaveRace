<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Zooming &amp; Panning</h1>
<div id="chartContainer"></div>

<?php 
	$dataPoints = array(
        array("y" => 41, "x" => 0),
        array("y" => 34, "x" => 1),
        array("y" => 38, "x" => 2),
        array("y" => 45, "x" => 3),
        array("y" => 40, "x" => 4),
        array("y" => 47, "x" => 5),
        array("y" => 44, "x" => 6),
        array("y" => 38, "x" => 7),
        array("y" => 45, "x" => 8),
        array("y" => 39, "x" => 9),
        array("y" => 40, "x" => 10),
        array("y" => 45, "x" => 11),
        array("y" => 53, "x" => 12),
        array("y" => 46, "x" => 13),
        array("y" => 49, "x" => 14),
        array("y" => 39, "x" => 15),
        array("y" => 40, "x" => 16),
        array("y" => 42, "x" => 17),
        array("y" => 32, "x" => 18),
        array("y" => 24, "x" => 19),
        array("y" => 26, "x" => 20),
        array("y" => 17, "x" => 21),
        array("y" => 25, "x" => 22),
        array("y" => 22, "x" => 23),
        array("y" => 18, "x" => 24),
        array("y" => 19, "x" => 25),
        array("y" => 21, "x" => 26),
        array("y" => 11, "x" => 27),
        array("y" => 20, "x" => 28),
        array("y" => 28, "x" => 29),
        array("y" => 26, "x" => 30),
        array("y" => 21, "x" => 31),
        array("y" => 16, "x" => 32),
        array("y" => 22, "x" => 33),
        array("y" => 29, "x" => 34),
        array("y" => 25, "x" => 35),
        array("y" => 17, "x" => 36),
        array("y" => 10, "x" => 37),
        array("y" => 19, "x" => 38),
        array("y" => 16, "x" => 39),
        array("y" => 6, "x" => 40),
        array("y" => 3, "x" => 41),
        array("y" => 9, "x" => 42),
        array("y" => 4, "x" => 43),
        array("y" => 11, "x" => 44),
        array("y" => 4, "x" => 45),
        array("y" => 10, "x" => 46),
        array("y" => 4, "x" => 47),
        array("y" => 4, "x" => 48),
        array("y" => 3, "x" => 49),
        array("y" => 6, "x" => 50),
        array("y" => -1, "x" => 51),
        array("y" => -3, "x" => 52),
        array("y" => -4, "x" => 53),
        array("y" => -3, "x" => 54),
        array("y" => 6, "x" => 55),
        array("y" => 1, "x" => 56),
        array("y" => -3, "x" => 57),
        array("y" => -2, "x" => 58),
        array("y" => 2, "x" => 59),
        array("y" => -4, "x" => 60),
        array("y" => -7, "x" => 61),
        array("y" => -13, "x" => 62),
        array("y" => -4, "x" => 63),
        array("y" => 1, "x" => 64),
        array("y" => -3, "x" => 65),
        array("y" => -4, "x" => 66),
        array("y" => -13, "x" => 67),
        array("y" => -17, "x" => 68),
        array("y" => -20, "x" => 69),
        array("y" => -12, "x" => 70),
        array("y" => -15, "x" => 71),
        array("y" => -12, "x" => 72),
        array("y" => -10, "x" => 73),
        array("y" => -19, "x" => 74),
        array("y" => -25, "x" => 75),
        array("y" => -30, "x" => 76),
        array("y" => -27, "x" => 77),
        array("y" => -27, "x" => 78),
        array("y" => -35, "x" => 79),
        array("y" => -31, "x" => 80),
        array("y" => -34, "x" => 81),
        array("y" => -35, "x" => 82),
        array("y" => -35, "x" => 83),
        array("y" => -41, "x" => 84),
        array("y" => -47, "x" => 85),
        array("y" => -40, "x" => 86),
        array("y" => -34, "x" => 87),
        array("y" => -40, "x" => 88),
        array("y" => -32, "x" => 89),
        array("y" => -42, "x" => 90),
        array("y" => -36, "x" => 91),
        array("y" => -34, "x" => 92),
        array("y" => -40, "x" => 93),
        array("y" => -48, "x" => 94),
        array("y" => -45, "x" => 95),
        array("y" => -53, "x" => 96),
        array("y" => -47, "x" => 97),
        array("y" => -48, "x" => 98),
        array("y" => -47, "x" => 99)
    );
?>

<script type="text/javascript">

$(function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        zoomEnabled: true,
        animationEnabled: true,
        title: {
            text: "Try Zooming & Panning"
        },
        subtitles:[
            {
            text: "Line Chart with 100 Data Points"
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