<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Bar Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints_1 = array(
	array("y" => 243, "label" => "France"),
	array("y" => 273, "label" => "Great Britain"),
	array("y" => 525, "label" => "Soviet Union"),
	array("y" => 1118, "label" => "USA")
    );
    
    $dataPoints_2 = array(
	array("y" => 272, "label" => "France"),
	array("y" => 299, "label" => "Great Britain"),
	array("y" => 419, "label" => "Soviet Union"),
	array("y" => 896, "label" => "USA")
    );
    
    $dataPoints_3 = array(
	array("y" => 307, "label" => "France"),
	array("y" => 301, "label" => "Great Britain"),
	array("y" => 392, "label" => "Soviet Union"),
	array("y" => 788, "label" => "USA")
    );
    
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Olympic Medals of all Times (till 2016 Olympics)"
            },
            subtitles: [
                {
                    text: "Click on Legends to Enable/Disable Data Series"
                }
            ],
            animationEnabled: true,
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
            },
            axisY: {
                title: "Medals"
            },
            toolTip: {
                shared: true,
                content: function (e) {
                    var str = '';
                    var total = 0;
                    var str3;
                    var str2;
                    for (var i = 0; i < e.entries.length; i++) {
                        var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                        total = e.entries[i].dataPoint.y + total;
                        str = str.concat(str1);
                    }
                    str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";
                    str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";

                    return (str2.concat(str)).concat(str3);
                }

            },
            data: [
            {
                type: "bar",
                showInLegend: true,
                name: "Gold",
                color: "gold",
                dataPoints: <?php echo json_encode($dataPoints_1, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "bar",
                showInLegend: true,
                name: "Silver",
                color: "silver",
                dataPoints: <?php echo json_encode($dataPoints_2, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "bar",
                showInLegend: true,
                name: "Bronze",
                color: "#A57164",
                dataPoints: <?php echo json_encode($dataPoints_3, JSON_NUMERIC_CHECK); ?>
            }

            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>