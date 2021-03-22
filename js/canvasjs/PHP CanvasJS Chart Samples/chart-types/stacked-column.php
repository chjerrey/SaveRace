<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Stacked Column Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
	array("y" => 111338, "label" => "USA"),
	array("y" => 49088, "label" => "Russia"),
	array("y" => 62200, "label" => "China"),
	array("y" => 90085, "label" => "India"),
	array("y" => 38600, "label" => "Australia"),
	array("y" => 48750, "label" => "SA")
);
    $dataPoints2 = array(
	array("y" => 135305, "label" => "USA"),
	array("y" => 107922, "label" => "Russia"),
	array("y" => 52300, "label" => "China"),
	array("y" => 3360, "label" => "India"),
	array("y" => 39900, "label" => "Australia"),
	array("y" => 0, "label" => "SA")
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Coal Reserves of Countries"
            },
            axisY: {
                title: "Coal (bn tonnes)",
                valueFormatString: "#0.#,."
            },
            data: [
            {
                type: "stackedColumn",
                legendText: "Anthracite & Bituminous",
                yValueFormatString: "#0.#,.",
                showInLegend: "true",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            }, {
                type: "stackedColumn",
                legendText: "SubBituminous & Lignite",
                showInLegend: "true",
                indexLabel: "#total bn",
                yValueFormatString: "#0.#,.",
                indexLabelFormatString: "#0.#,.",
                indexLabelPlacement: "outside",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>