<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Spline Chart</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
	array("y" => 17363, "label" => "2005-06"),
	array("y" => 28726, "label" => "2006-07"),
	array("y" => 35000, "label" => "2007-08"),
	array("y" => 25250, "label" => "2008-09"),
	array("y" => 19750, "label" => "2009-10"),
	array("y" => 18850, "label" => "2010-11"),
	array("y" => 26700, "label" => "2011-12"),
	array("y" => 16000, "label" => "2012-13"),
	array("y" => 19000, "label" => "2013-14"),
	array("y" => 18000, "label" => "2014-15")
    );
?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Analysis of Pepper Export - India"
            },
            axisX: {
                title: "Year"
            },
            axisY: {
                title: "In Tonnes"
            },

            data: [
            {
                type: "spline",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });

        chart.render();
    });
</script>

<?php include '../footer.php'; ?>