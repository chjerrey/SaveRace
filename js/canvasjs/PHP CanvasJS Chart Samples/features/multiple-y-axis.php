<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Multiple Y Axis</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
        array("x" => 0, "y" => 0),
        array("x" => 11, "y" => 8.2),
        array("x" => 47, "y" => 41.7),
        array("x" => 56, "y" => 16.7),
        array("x" => 120, "y" => 31.3),
        array("x" => 131, "y" => 18.2),
        array("x" => 171, "y" => 31.3),
        array("x" => 189, "y" => 61.1),
        array("x" => 221, "y" => 40.6),
        array("x" => 232, "y" => 18.2),
        array("x" => 249, "y" => 35.3),
        array("x" => 253, "y" => 12.5),
        array("x" => 264, "y" => 16.4),
        array("x" => 280, "y" => 37.5),
        array("x" => 303, "y" => 24.3),
        array("x" => 346, "y" => 23.3),
        array("x" => 376, "y" => 11.3),
        array("x" => 388, "y" => 8.3),
        array("x" => 430, "y" => 1.9),
        array("x" => 451, "y" => 4.8)
    );

    $dataPoints2 = array(
        array("x" => 0, "y" => 0),
        array("x" => 11, "y" => 90),
        array("x" => 47, "y" => 1590),
        array("x" => 56, "y" => 1740),
        array("x" => 120, "y" => 3740),
        array("x" => 131, "y" => 3940),
        array("x" => 171, "y" => 5190),
        array("x" => 189, "y" => 6290),
        array("x" => 221, "y" => 7590),
        array("x" => 232, "y" => 7790),
        array("x" => 249, "y" => 8390),
        array("x" => 253, "y" => 8440),
        array("x" => 264, "y" => 8620),
        array("x" => 280, "y" => 9220),
        array("x" => 303, "y" => 9780),
        array("x" => 346, "y" => 10780),
        array("x" => 376, "y" => 11120),
        array("x" => 388, "y" => 11220),
        array("x" => 430, "y" => 11300),
        array("x" => 451, "y" => 11400)
    );;
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Speed And Distance Time Graph"
            },
            animationEnabled: true,
            toolTip: {
                shared: true,
                content: function (e) {
                    var body;
                    var head;
                    head = "<span style = 'color:DodgerBlue; '><strong>" + (e.entries[0].dataPoint.x) + " sec</strong></span><br/>";

                    body = "<span style= 'color:" + e.entries[0].dataSeries.color + "'> " + e.entries[0].dataSeries.name + "</span>: <strong>" + e.entries[0].dataPoint.y + "</strong>  m/s<br/> <span style= 'color:" + e.entries[1].dataSeries.color + "'> " + e.entries[1].dataSeries.name + "</span>: <strong>" + e.entries[1].dataPoint.y + "</strong>  m";

                    return (head.concat(body));
                }
            },
            axisY: {
                title: "Speed",
                includeZero: false,
                suffix: " m/s",
                lineColor: "#369EAD"
            },
            axisY2: {
                title: "Distance",
                includeZero: false,
                suffix: " m",
                lineColor: "#C24642"
            },
            axisX: {
                title: "Time",
                suffix: " s"
            },
            data: [
            {
                type: "spline",
                name: "Speed",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                axisYType: "secondary",
                name: "Distance Covered",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>