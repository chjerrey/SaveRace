<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Stacked Area Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints1 = array(
	array("x" => 1363458600000, "y" => 2.4),
	array("x" => 1363545000000, "y" => 0.6),
	array("x" => 1363631400000, "y" => 0.8),
	array("x" => 1363717800000, "y" => 1.6),
	array("x" => 1363804200000, "y" => 1.4),
	array("x" => 1363890600000, "y" => 1.4),
	array("x" => 1363977000000, "y" => 2.6)
    );
    $dataPoints2 = array(
	array("x" => 1363458600000, "y" => 3.3),
	array("x" => 1363545000000, "y" => 1.6),
	array("x" => 1363631400000, "y" => 2.1),
	array("x" => 1363717800000, "y" => 1.6),
	array("x" => 1363804200000, "y" => 1.4),
	array("x" => 1363890600000, "y" => 1.7),
	array("x" => 1363977000000, "y" => 4.6)
    );
    $dataPoints3 = array(
	array("x" => 1363458600000, "y" => 2.4),
	array("x" => 1363545000000, "y" => 2),
	array("x" => 1363631400000, "y" => 2.8),
	array("x" => 1363717800000, "y" => 1.6),
	array("x" => 1363804200000, "y" => 1.4),
	array("x" => 1363890600000, "y" => 1.4),
	array("x" => 1363977000000, "y" => 1.6)
    );
    $dataPoints4 = array(
	array("x" => 1363458600000, "y" => 0.4),
	array("x" => 1363545000000, "y" => 7),
	array("x" => 1363631400000, "y" => 6.8),
	array("x" => 1363717800000, "y" => 4.6),
	array("x" => 1363804200000, "y" => 6.4),
	array("x" => 1363890600000, "y" => 7.4),
	array("x" => 1363977000000, "y" => 1.6)
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Productivity by Day"
            },
            subtitles: [
                {
                    text: "Click on Legends to Enable/Disable Data Series"
                }
            ],
            animationEnabled: true,
            axisX: {
                valueFormatString: "DDD"
            },

            legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
            },
            toolTip: {
                content: function (e) {
                    var weekday = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                    var str1 = weekday[e.entries[0].dataPoint.x.getDay()] + "<br/>  <span style =' color:" + e.entries[0].dataSeries.color + "';>" + e.entries[0].dataSeries.name + "</span>: <strong>" + e.entries[0].dataPoint.y + " hrs</strong> <br/>";
                    return str1
                }
            },

            data: [
              {
                  type: "stackedArea",
                  name: "Very Distracting",
                  showInLegend: true,
                  legendMarkerType: "square",
                  color: "rgba(211,19,14,.8)",
                  markerSize: 0,
                  xValueType: "dateTime",
                  dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
              },
              {
                  type: "stackedArea",
                  name: "Distracting",
                  showInLegend: true,
                  legendMarkerType: "square",
                  markerSize: 0,
                  color: "rgba(95,53,87,.8)",
                  xValueType: "dateTime",
                  dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
              },

            {
                type: "stackedArea",
                name: "Productive",
                showInLegend: true,
                legendMarkerType: "square",
                markerSize: 0,
                color: "rgba(60,84,151,.9)",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea",
                name: "Very Productive",
                showInLegend: true,
                legendMarkerType: "square",
                markerSize: 0,
                color: "rgba(22,115,211,.9)",
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            }
            ]
              ,
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