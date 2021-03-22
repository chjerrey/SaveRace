<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Stacked Column 100% Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
	array("y" => 40, "label" => "Cafeteria"),
	array("y" => 10, "label" => "Lounge"),
	array("y" => 72, "label" => "Games Room"),
	array("y" => 30, "label" => "Lecture Hall"),
	array("y" => 21, "label" => "Library")
    );
    $dataPoints2 = array(
	array("y" => 20, "label" => "Cafeteria"),
	array("y" => 14, "label" => "Lounge"),
	array("y" => 40, "label" => "Games Room"),
	array("y" => 43, "label" => "Lecture Hall"),
	array("y" => 17, "label" => "Library")
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Number of Students in Each Room"
            },
            axisX: {
                title: "Rooms"
            },
            axisY: {
                title: "percentage"
            },
            data: [
            {
                type: "stackedColumn100",
                legendText: "Boys",
                showInLegend: "true",
                indexLabel: "#percent %",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedColumn100",
                legendText: "Girls",
                showInLegend: "true",
                indexLabel: "#percent %",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>