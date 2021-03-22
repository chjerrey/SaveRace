<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Add Data Points From User Input</h1>
<div style="margin-left:7%">
    X Value:<input id="xValue" type="number" step="any" placeholder="Enter X-Value">
    Y Value:<input id="yValue" type="number" step="any" placeholder="Enter Y-Value">
    <button id="renderButton" class="btn btn-info" type="submit" value="Add DataPoints & Render Chart">Add DataPoints &amp; Render Chart</button>
</div>
<div id="chartContainer" style="width:100%; height:400px"></div>


<script type="text/javascript">

    $(function () {
        var dps = []; //dataPoints.

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Accepting DataPoints from User Input"
            },
            data: [{
                type: "column",
                dataPoints: dps
            }]
        });

        function addDataPointsAndRender() {
            var xValue = Number(document.getElementById('xValue').value);
            var yValue = Number(document.getElementById('yValue').value);
            dps.push({
                x: xValue,
                y: yValue
            });
            chart.render();
        }

		$('#renderButton').click(addDataPointsAndRender);
    });
</script>

<?php include '../footer.php'; ?>