<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Reverse Axis</h1>
<div id="chartContainer"></div>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Column Chart with Reversed Y Axis"
            },
            axisY: {
                title: "Reversed Axis",
                reversed: true
            },
            data: [
            {
                type: "column",
                dataPoints: [
                    { y: 6, label: "Apple" },
					{ y: 4, label: "Mango" },
					{ y: 5, label: "Orange" },
					{ y: 7, label: "Banana" },
					{ y: 4, label: "Pineapple" },
					{ y: 6, label: "Pears" },
					{ y: 7, label: "Grapes" },
					{ y: 5, label: "Lychee" },
					{ y: 4, label: "Jackfruit" }
                ]
            }
            ]
        });
        chart.render();
    });
</script>

<?php include '../footer.php'; ?>