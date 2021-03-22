<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Hide / Show DataSeries on Legend Click</h1>
<div id="chartContainer" style="height: 400px; width: 100%;"></div>

<?php
    $dataPoints1 = array(
	array("x" => 2009, "y" => 1.6),
	array("x" => 2010, "y" => 9.6),
	array("x" => 2011, "y" => 36.4),
	array("x" => 2012, "y" => 56.9),
	array("x" => 2013, "y" => 74.4),
	array("x" => 2014, "y" => 80.8),
	array("x" => 2015, "y" => 78.8),
	array("x" => 2016, "y" => 84.1)
    );
    $dataPoints2 = array(
	array("x" => 2009, "y" => 10.5),
	array("x" => 2010, "y" => 15.4),
	array("x" => 2011, "y" => 16.9),
	array("x" => 2012, "y" => 22.5),
	array("x" => 2013, "y" => 18.2),
	array("x" => 2014, "y" => 15.3),
	array("x" => 2015, "y" => 17.9),
	array("x" => 2016, "y" => 14.8)
    );
    $dataPoints3 = array(
	array("x" => 2009, "y" => 10.2),
	array("x" => 2010, "y" => 6.8),
	array("x" => 2011, "y" => 2.6),
	array("x" => 2012, "y" => 1.9),
	array("x" => 2013, "y" => 2.9),
	array("x" => 2014, "y" => 2.6),
	array("x" => 2015, "y" => 2.4),
	array("x" => 2016, "y" => 0.6)
    );
    $dataPoints4 = array(
	array("x" => 2009, "y" => 20.6),
	array("x" => 2010, "y" => 19.7),
	array("x" => 2011, "y" => 13),
	array("x" => 2012, "y" => 6.8),
	array("x" => 2013, "y" => 3),
	array("x" => 2014, "y" => 0.6),
	array("x" => 2015, "y" => 0.4),
	array("x" => 2016, "y" => 0.2)
    );
    $dataPoints5 = array(
	array("x" => 2009, "y" => 48.8),
	array("x" => 2010, "y" => 44.2),
	array("x" => 2011, "y" => 27.7),
	array("x" => 2012, "y" => 8.5),
	array("x" => 2013, "y" => 0.6),
	array("x" => 2014, "y" => 0.6),
	array("x" => 2015, "y" => 0.4),
	array("x" => 2016, "y" => 0.2)
    );
    $dataPoints6 = array(
	array("x" => 2009, "y" => 8.3),
	array("x" => 2010, "y" => 4.3),
	array("x" => 2011, "y" => 3.4),
	array("x" => 2012, "y" => 3.4),
	array("x" => 2013, "y" => 0.9),
	array("x" => 2014, "y" => 0.1),
	array("x" => 2015, "y" => 0.1),
	array("x" => 2016, "y" => 0.1)
    );
    
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Global Mobile OS Market Share in Sales to End Users"
            },
            subtitles: [
                {
                    text: "Click on Legends to Enable/Disable DataSeries"
                }
            ],
            axisX: {
                title: "Year",
                valueFormatString: "####"
            },
            axisY: {
                title: "Share of Global Sales to the end user",
                titleFontSize: 16
            },
            toolTip: {
                shared: true,
                content: "<span style='\"'color: {color};'\"'>{name}</span> : {y}%"
            },
            data: [
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "Android",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "iOS",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "Microsoft",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "RIM BlackBerry",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "Symbian",
                dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea100",
                xValueFormatString: "####",
                showInLegend: true,
                name: "Others",
                dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
            }
            ],
            legend: {
                cursor: "pointer",
                verticalAlign: "top",
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