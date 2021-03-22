<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Stacked Bar 100% Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
	array("y" => 350, "label" => "George"),
	array("y" => 350, "label" => "Alex"),
	array("y" => 350, "label" => "Mike"),
	array("y" => 374, "label" => "Jake"),
	array("y" => 320, "label" => "Shah"),
	array("y" => 300, "label" => "Joe"),
	array("y" => 400, "label" => "Fin"),
	array("y" => 220, "label" => "Larry")
    );
    $dataPoints2 = array(
	array("y" => 250, "label" => "George"),
	array("y" => 280, "label" => "Alex"),
	array("y" => 350, "label" => "Mike"),
	array("y" => 274, "label" => "Jake"),
	array("y" => 320, "label" => "Shah"),
	array("y" => 320, "label" => "Joe"),
	array("y" => 280, "label" => "Fin"),
	array("y" => 420, "label" => "Larry")
    );
    $dataPoints3 = array(
	array("y" => 350, "label" => "George"),
	array("y" => 350, "label" => "Alex"),
	array("y" => 350, "label" => "Mike"),
	array("y" => 374, "label" => "Jake"),
	array("y" => 120, "label" => "Shah"),
	array("y" => 120, "label" => "Joe"),
	array("y" => 400, "label" => "Fin"),
	array("y" => 120, "label" => "Larry")
    );
    $dataPoints4 = array(
	array("y" => 250, "label" => "George"),
	array("y" => 250, "label" => "Alex"),
	array("y" => 250, "label" => "Mike"),
	array("y" => 274, "label" => "Jake"),
	array("y" => 320, "label" => "Shah"),
	array("y" => 220, "label" => "Joe"),
	array("y" => 100, "label" => "Fin"),
	array("y" => 420, "label" => "Larry")
    );
    $dataPoints5 = array(
	array("y" => 150, "label" => "George"),
	array("y" => 30, "label" => "Alex"),
	array("y" => 45, "label" => "Mike"),
	array("y" => 74, "label" => "Jake"),
	array("y" => 64, "label" => "Shah"),
	array("y" => 40, "label" => "Joe"),
	array("y" => 50, "label" => "Fin"),
	array("y" => 40, "label" => "Larry")
    );
    $dataPoints6 = array(
	array("y" => 150, "label" => "George"),
	array("y" => 170, "label" => "Alex"),
	array("y" => 150, "label" => "Mike"),
	array("y" => 174, "label" => "Jake"),
	array("y" => 120, "label" => "Shah"),
	array("y" => 160, "label" => "Joe"),
	array("y" => 100, "label" => "Fin"),
	array("y" => 80, "label" => "Larry")
    );
    $dataPoints7 = array(
	array("y" => 160, "label" => "George"),
	array("y" => 170, "label" => "Alex"),
	array("y" => 50, "label" => "Mike"),
	array("y" => 174, "label" => "Jake"),
	array("y" => 104, "label" => "Shah"),
	array("y" => 120, "label" => "Joe"),
	array("y" => 300, "label" => "Fin"),
	array("y" => 420, "label" => "Larry")
    );
    $dataPoints8 = array(
	array("y" => 80, "label" => "George"),
	array("y" => 150, "label" => "Alex"),
	array("y" => 50, "label" => "Mike"),
	array("y" => 74, "label" => "Jake"),
	array("y" => 40, "label" => "Shah"),
	array("y" => 120, "label" => "Joe"),
	array("y" => 100, "label" => "Fin"),
	array("y" => 120, "label" => "Larry")
    );
    
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: 'light2',
            title: {
                text: "Time Spent in Holiday Season"
            },
            animationEnabled: true,
            axisY: {
                title: "percent"
            },
            legend: {
                horizontalAlign: 'center',
                verticalAlign: 'bottom'
            },
            toolTip: {
                shared: true,
                content: "<span style='\"'color: {color};'\"'>{name}</span> : {y}min"
            },
            data: [
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "With Friends",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Eating Out",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Reading",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Shopping",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Fitness",
                dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Travel",
                dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Internet",
                dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedBar100",
                showInLegend: true,
                name: "Hobbies",
                dataPoints: <?php echo json_encode($dataPoints8, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>