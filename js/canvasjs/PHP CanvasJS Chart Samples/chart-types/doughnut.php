<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Doughnut Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
        array("y" => 72.48, "legendText" => "Google", "label" => "Google"),
        array("y" => 10.39, "legendText" => "Bing", "label" => "Bing"),
        array("y" => 7.78, "legendText" => "Yahoo!", "label" => "Yahoo!"),
        array("y" => 7.14, "legendText" => "Baidu", "label" => "Baidu"),
        array("y" => 0.22, "legendText" => "Ask", "label" => "Ask"),
        array("y" => 0.15, "legendText" => "AOL", "label" => "AOL"),
        array("y" => 1.84, "legendText" => "Others", "label" => "Others")
    );
?>

<script type="text/javascript">
    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Desktop Search Engine Market Share, Jul-2016"
            },
            animationEnabled: true,
            legend: {
                fontSize: 20,
                fontFamily: "Helvetica"
            },
            theme: "light2",
            data: [
            {
                type: "doughnut",
                indexLabelFontFamily: "Garamond",
                indexLabelFontSize: 20,
                indexLabel: "{label} {y}%",
                startAngle: -20,
                showInLegend: true,
                toolTipContent: "{legendText} {y}%",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>