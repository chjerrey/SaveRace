<?php include '../header.php'; ?>
<?php include '../sidebar.php'; ?>
<?php include '../content.php'; ?>
<h1>Logarithmic Axis</h1>
<div id="chartContainer"></div>

<?php
    $dataPoints = array(
        array("x" => 1971, "y" => 2300, "name" => "Intel 4004"),
        array("x" => 1972, "y" => 3500, "name" => "Intel 8008"),
        array("x" => 1974, "y" => 4100, "name" => "Motorola 6800"),
        array("x" => 1974, "y" => 4500, "name" => "Intel 8080"),
        array("x" => 1974, "y" => 5000, "name" => "RCA 1802"),
        array("x" => 1975, "y" => 3510, "name" => "MOS Technology 6502"),
        array("x" => 1976, "y" => 6500, "name" => "Intel 8085"),
        array("x" => 1976, "y" => 8500, "name" => "Zilog Z80"),
        array("x" => 1978, "y" => 9000, "name" => "Motorola 6809"),
        array("x" => 1978, "y" => 29000, "name" => "Intel 8086"),
        array("x" => 1979, "y" => 29000, "name" => "Intel 8088"),
        array("x" => 1979, "y" => 68000, "name" => "Motorola 68000"),
        array("x" => 1982, "y" => 55000, "name" => "Intel 80186"),
        array("x" => 1982, "y" => 134000, "name" => "Intel 80286"),
        array("x" => 1985, "y" => 25000, "name" => "ARM 1"),
        array("x" => 1985, "y" => 275000, "name" => "Intel 80386"),
        array("x" => 1986, "y" => 25000, "name" => "ARM 2"),
        array("x" => 1989, "y" => 300000, "name" => "ARM 3"),
        array("x" => 1989, "y" => 1180235, "name" => "Intel 80486"),
        array("x" => 1991, "y" => 30000, "name" => "ARM 6"),
        array("x" => 1991, "y" => 1350000, "name" => "R4000"),
        array("x" => 1993, "y" => 3100000, "name" => "Pentium"),
        array("x" => 1994, "y" => 578977, "name" => "ARM 7"),
        array("x" => 1995, "y" => 5500000, "name" => "Pentium Pro"),
        array("x" => 1996, "y" => 4300000, "name" => "AMD K5"),
        array("x" => 1997, "y" => 7500000, "name" => "Pentium II"),
        array("x" => 1997, "y" => 8800000, "name" => "AMD K6"),
        array("x" => 1999, "y" => 9500000, "name" => "Pentium III"),
        array("x" => 1999, "y" => 21300000, "name" => "AMD K6 III"),
        array("x" => 1999, "y" => 22000000, "name" => "AMD K7"),
        array("x" => 2000, "y" => 42000000, "name" => "Pentium 4"),
        array("x" => 2002, "y" => 105900000, "name" => "AMD K8"),
        array("x" => 2003, "y" => 54300000, "name" => "Barton"),
        array("x" => 2003, "y" => 291000000, "name" => "Core 2 Duo"),
        array("x" => 2003, "y" => 410000000, "name" => "Itanium 2 Madison 6M "),
        array("x" => 2004, "y" => 592000000, "name" => "Itanium 2 with 9MB cache "),
        array("x" => 2006, "y" => 220000000, "name" => "Itanium 2 McKinley "),
        array("x" => 2006, "y" => 241000000, "name" => "Cell"),
        array("x" => 2006, "y" => 1700000000, "name" => "Dual-Core Itanium 2"),
        array("x" => 2007, "y" => 26000000, "name" => "ARM Cortex-A9"),
        array("x" => 2007, "y" => 463000000, "name" => "AMD K10 quad-core 2M L3 "),
        array("x" => 2007, "y" => 789000000, "name" => "POWER 6"),
        array("x" => 2008, "y" => 47000000, "name" => "Atom"),
        array("x" => 2008, "y" => 731000000, "name" => "Core i7 (Quad)"),
        array("x" => 2008, "y" => 758000000, "name" => "AMD K10 quad-core 6M L3 "),
        array("x" => 2008, "y" => 1900000000, "name" => "Six-Core Xeon 7400"),
        array("x" => 2009, "y" => 904000000, "name" => "Six-Core Opteron 2400 "),
        array("x" => 2010, "y" => 1000000000, "name" => "16-Core SPARC T3"),
        array("x" => 2010, "y" => 1170000000, "name" => "Six-Core Core i7"),
        array("x" => 2010, "y" => 1200000000, "name" => "8-core POWER7 32M L3"),
        array("x" => 2010, "y" => 1400000000, "name" => "Quad-core z196"),
        array("x" => 2010, "y" => 2000000000, "name" => "Quad-Core Itanium Tukwila"),
        array("x" => 2010, "y" => 2300000000, "name" => "8-Core Xeon Nehalem-EX"),
        array("x" => 2011, "y" => 1160000000, "name" => "Quad-Core + GPU Core i7"),
        array("x" => 2011, "y" => 2270000000, "name" => "Six-Core Core i7/8-Core Xeon E5"),
        array("x" => 2011, "y" => 2600000000, "name" => "10-Core Xeon Westmere-EX"),
        array("x" => 2012, "y" => 1200000000, "name" => "8-Core AMD Bulldozer"),
        array("x" => 2012, "y" => 1303000000, "name" => "Quad-Core + GPU AMD Trinity"),
        array("x" => 2012, "y" => 1400000000, "name" => "Quad-Core + GPU Core i7"),
        array("x" => 2012, "y" => 2100000000, "name" => "8-core POWER7+ 80M L3"),
        array("x" => 2012, "y" => 2750000000, "name" => "Six-core zEC12"),
        array("x" => 2012, "y" => 3100000000, "name" => "8-Core Itanium Poulson"),
        array("x" => 2012, "y" => 5000000000, "name" => "62-Core Xeon Phi"),
        array("x" => 2013, "y" => 5000000000, "name" => "Xbox One Main SoC")
    );
?>

<script type="text/javascript">

$(function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        zoomEnabled: true,
        zoomType: "xy",
        title: {
            text: "Growth in Microprocessor Transistor Count"
        },
        subtitles: [
            {
                text: "Try Zooming and Panning"
            }
        ],
        axisX: {
            title: "Year",
            valueFormatString: "####"
        },
        axisY: {
            title: "No of Transistors per Chip",
            logarithmic: true,
            includeZero: false
        },
        toolTip: {
            content: "{x}<br/><span style='\"'color: {color};'\"'>{name}</span> - {y}"
        },
        data: [{
            type: "line",
            xValueFormatString: "####",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?> 
        }]
    });

    chart.render();
});
</script>

<?php include '../footer.php'; ?>