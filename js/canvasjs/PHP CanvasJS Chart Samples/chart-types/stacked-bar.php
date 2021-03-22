<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Stacked Bar Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
	array("y" => 3, "label" => "India"),
	array("y" => 5, "label" => "US"),
	array("y" => 3, "label" => "Germany"),
	array("y" => 6, "label" => "Brazil"),
	array("y" => 7, "label" => "China"),
	array("y" => 5, "label" => "Australia"),
	array("y" => 5, "label" => "France"),
	array("y" => 7, "label" => "Italy"),
	array("y" => 9, "label" => "Singapore"),
	array("y" => 8, "label" => "Switzerland"),
	array("y" => 12, "label" => "Japan")
    );
    $dataPoints2 = array(
	array("y" => 0.5, "label" => "India"),
	array("y" => 1.5, "label" => "US"),
	array("y" => 1, "label" => "Germany"),
	array("y" => 2, "label" => "Brazil"),
	array("y" => 2, "label" => "China"),
	array("y" => 2.5, "label" => "Australia"),
	array("y" => 1.5, "label" => "France"),
	array("y" => 1, "label" => "Italy"),
	array("y" => 2, "label" => "Singapore"),
	array("y" => 2, "label" => "Switzerland"),
	array("y" => 3, "label" => "Japan")
    );
    $dataPoints3 = array(
	array("y" => 2, "label" => "India"),
	array("y" => 3, "label" => "US"),
	array("y" => 3, "label" => "Germany"),
	array("y" => 3, "label" => "Brazil"),
	array("y" => 4, "label" => "China"),
	array("y" => 3, "label" => "Australia"),
	array("y" => 4.5, "label" => "France"),
	array("y" => 4.5, "label" => "Italy"),
	array("y" => 6, "label" => "Singapore"),
	array("y" => 3, "label" => "Switzerland"),
	array("y" => 6, "label" => "Japan")
    );
    $dataPoints4 = array(
	array("y" => 2, "label" => "India"),
	array("y" => 3, "label" => "US"),
	array("y" => 6, "label" => "Germany"),
	array("y" => 4, "label" => "Brazil"),
	array("y" => 4, "label" => "China"),
	array("y" => 8, "label" => "Australia"),
	array("y" => 8, "label" => "France"),
	array("y" => 8, "label" => "Italy"),
	array("y" => 4, "label" => "Singapore"),
	array("y" => 11, "label" => "Switzerland"),
	array("y" => 6, "label" => "Japan")
    );
    
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Cost Of Pancake Ingredients, 2011"
            },
            animationEnabled: true,
            axisY2: {
                valueFormatString: "$ 0"
            },
            toolTip: {
                shared: true
            },
            legend: {
                verticalAlign: "top",
                horizontalAlign: "center"
            },

            data: [
            {
                type: "stackedBar",
                showInLegend: true,
                name: "Butter (500gms)",
                axisYType: "secondary",
                color: "#7E8F74",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar",
                showInLegend: true,
                name: "Flour (1kg)",
                axisYType: "secondary",
                color: "#F0E6A7",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar",
                showInLegend: true,
                name: "Milk (2l)",
                axisYType: "secondary",
                color: "#EBB88A",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar",
                showInLegend: true,
                name: "Eggs (20)",
                axisYType: "secondary",
                color: "#DB9079",
                indexLabel: "$#total",
                indexLabelPlacement: "outside",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>