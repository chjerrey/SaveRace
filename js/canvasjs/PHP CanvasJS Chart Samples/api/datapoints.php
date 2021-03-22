<?php

$callback = filter_input(INPUT_GET,"callback",FILTER_SANITIZE_STRING);
$length = filter_input(INPUT_GET,"length",FILTER_SANITIZE_NUMBER_INT);
$xStart = filter_input(INPUT_GET,"xstart",FILTER_SANITIZE_NUMBER_FLOAT);
$yStart = filter_input(INPUT_GET,"ystart",FILTER_SANITIZE_NUMBER_FLOAT);
$noOfY = filter_input(INPUT_GET,"noofy",FILTER_SANITIZE_NUMBER_FLOAT);
$type = filter_input(INPUT_GET,"type",FILTER_SANITIZE_STRING);

$callback = $callback ? $callback : null;
$length = $length ? min($length, 100000) : 10;
$xStart = $xStart ? $xStart : 0;
$yStart = $yStart ? $yStart : 10;
$noOfY = $noOfY ? $noOfY : 1;
$type = $type ? $type : "json";

$dataPoints = get_random_data($xStart, $yStart, $noOfY, $length);

if($type === "xml")
	output_xml($dataPoints);
else if($type === "csv"){
	output_csv($dataPoints);
}	
else
	output_json($dataPoints, $callback);

function get_random_data($xStart = 0, $yStart = 10, $numberOfY = 1, $length = 10){
	
	$y1 = $yStart;
	$x = $xStart;
	$dataPoints = array();
	
	for($i = 0; $i < $length; $i++){
		$y1 += rand(0, 10) - 5;
		$x = $xStart + $i;
		
		//$dataPoint = array("x" => $xStart, "y" => $y1);
		$dataPoint = array($x, $y1);
		array_push($dataPoints, $dataPoint);
	}
	
	return $dataPoints;	
}

function output_json($dataPoints, $callback = null){
	$output = json_encode($dataPoints, JSON_NUMERIC_CHECK, JSON_UNESCAPED_UNICODE);

	if(!$callback)
	{	
		header('content-type: application/json; charset=utf-8');
		echo $output;
	}
	else{
		jsonp($output, $callback);		
	}
}

function output_csv($dataPoints, $callback = null){
	header('content-type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=dataPoints.csv');

	$outstream = fopen("php://output", 'w');

	foreach ($dataPoints as $dataPoint) {
    	fputcsv($outstream, $dataPoint, ",");
	}
}

function jsonp($content, $callback){
	header('content-type: text/javascript; charset=utf-8');
	//header('Access-Control-Allow-Origin: *');
	//header('Access-Control-Max-Age: 3628800');
	//header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	echo $callback.'('.$content.');';
}

function output_xml($dataPoints){
	
	$xml = new SimpleXMLElement('<data/>');

	$length = count($dataPoints);
	for($i = 0; $i < $length; $i++){
		$dataPoint = $dataPoints[$i];

		$dpNode = $xml->addChild("point");
		
		$dpNode->addChild("x", $dataPoint[0]);
		$dpNode->addChild("y", $dataPoint[1]);
	}
	//echo $xml->asXML();
	$output = utf8_encode($xml->asXML());

	header("Content-type: text/xml; charset=utf-8");
	echo $output;
}



function convert_to_xml(SimpleXMLElement $object, array $dataPoints)
{   

	$length = count($dataPoints);
	for($i = 0; $i < $length; $i++){
		$dataPoint = $dataPoints[$i];

		if(is_array($dataPoint)){
			$dataPoint = $xml->addChild("point");
            convert_to_xml($dataPoint, $value);
		}
	}
}

?>