<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Multiseries Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
        array("label" => "Atlanta 1996", "y" => 44),
        array("label" => "Sydney 2000", "y" => 37),
        array("label" => "Athens 2004", "y" => 34),
        array("label" => "Beijing 2008", "y" => 36),
        array("label" => "London 2012", "y" => 46),
        array("label" => "Brazil 2016", "y" => 46)
    );

    $dataPoints2 = array(
        array("label" => "Atlanta 1996", "y" => 16),
        array("label" => "Sydney 2000", "y" => 28),
        array("label" => "Athens 2004", "y" => 32),
        array("label" => "Beijing 2008", "y" => 51),
        array("label" => "London 2012", "y" => 38),
        array("label" => "Brazil 2016", "y" => 26)
    );

    $dataPoints3 = array(
        array("label" => "Atlanta 1996", "y" => 1),
        array("label" => "Sydney 2000", "y" => 11),
        array("label" => "Athens 2004", "y" => 9),
        array("label" => "Beijing 2008", "y" => 19),
        array("label" => "London 2012", "y" => 29),
        array("label" => "Brazil 2016", "y" => 27)
    );

    $dataPoints4 = array(
        array("label" => "Atlanta 1996", "y" => 26),
        array("label" => "Sydney 2000", "y" => 32),
        array("label" => "Athens 2004", "y" => 28),
        array("label" => "Beijing 2008", "y" => 23),
        array("label" => "London 2012", "y" => 24),
        array("label" => "Brazil 2016", "y" => 19)
    );

    $dataPoints5 = array(
        array("label" => "Atlanta 1996", "y" => 7),
        array("label" => "Sydney 2000", "y" => 8),
        array("label" => "Athens 2004", "y" => 9),
        array("label" => "Beijing 2008", "y" => 13),
        array("label" => "London 2012", "y" => 13),
        array("label" => "Brazil 2016", "y" => 9)
    );

    $dataPoints6 = array(
        array("label" => "Atlanta 1996", "y" => 20),
        array("label" => "Sydney 2000", "y" => 13),
        array("label" => "Athens 2004", "y" => 13),
        array("label" => "Beijing 2008", "y" => 16),
        array("label" => "London 2012", "y" => 11),
        array("label" => "Brazil 2016", "y" => 17)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Gold Won in Olympics (Till 2016)"
            },
            subtitles: [
                {
                    text: "Click on Legend to Hide/Unhide Data Series"
                }
            ],
            animationEnabled: true,
            axisY: {
                titleFontFamily: "arial",
                titleFontSize: 12,
                includeZero: false
            },
            toolTip: {
                shared: true
            },
            data: [
            {
                type: "spline",
                name: "US",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                name: "China",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                name: "Britain",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                name: "Russia",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                name: "S Korea",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "spline",
                name: "Germany",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
            }
            ],
            legend: {
                cursor: "pointer",
                itemclick: function (e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    }
                    else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }
            }
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>