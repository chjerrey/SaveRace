<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>PHP Chart Samples using CanvasJS</title>
		
		<!-- stylesheets -->
		<link href="/js/canvasjs/PHP CanvasJS Chart Samples/assets/bootstrap.min.css" rel="stylesheet">
		<link href="/js/canvasjs/PHP CanvasJS Chart Samples/assets/style.css" rel="stylesheet">
		<link href="/js/canvasjs/PHP CanvasJS Chart Samples/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- scripts -->
		
		<!--[if lt IE 9 ]> 
		<script src="/js/canvasjs/PHP CanvasJS Chart Samples/assets/js/html5shiv.min.js"></script>
		<script src="/js/canvasjs/PHP CanvasJS Chart Samples/assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!--script src="/js/canvasjs/PHP CanvasJS Chart Samples/assets/js/	"></script-->
		<script src="/js/canvasjs/PHP CanvasJS Chart Samples/assets/js/jquery-1.12.4.min.js"></script>
		<script src="/js/canvasjs/PHP CanvasJS Chart Samples/assets/js/bootstrap.min.js"></script>
		
		
		<script>
			$(function () {
				// #sidebar-toggle-button
				$('#sidebar-toggle-button').on('click', function () {
						$('#sidebar').toggleClass('sidebar-toggle');
						$('#page-content-wrapper').toggleClass('page-content-toggle');	
						fireResize();					
				});
				
				// sidebar collapse behavior
				$('#sidebar').on('show.bs.collapse', function () {
					$('#sidebar').find('.collapse.in').collapse('hide');
				});
				
				// To make current link active
				var pageURL = $(location).attr('href');
				var URLSplits = pageURL.split('/');

				//console.log(pageURL + "; " + URLSplits.length);
				//$(".sub-menu .collapse .in").removeClass("in");

				if (URLSplits.length === 5) {
					var routeURL = '/' + URLSplits[URLSplits.length - 2] + '/' + URLSplits[URLSplits.length - 1];
					var activeNestedList = $('.sub-menu > li > a[href="' + routeURL + '"]').parent();

					if (activeNestedList.length !== 0 && !activeNestedList.hasClass('active')) {
						$('.sub-menu > li').removeClass('active');
						activeNestedList.addClass('active');
						activeNestedList.parent().addClass("in");
					}
				}

				function fireResize() {
					if (document.createEvent) { // W3C
						var ev = document.createEvent('Event');
						ev.initEvent('resize', true, true);
						window.dispatchEvent(ev);
					}
					else { // IE
						element = document.documentElement;
						var event = document.createEventObject();
						element.fireEvent("onresize", event);
					}
            	}
			})
		</script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		
	</head>
	
	<body>
		<!-- header -->
		<nav id="header" class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<div id="sidebar-toggle-button">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</div>
					<div class="brand">
						<a href="/js/canvasjs/PHP CanvasJS Chart Samples/">
							CanvasJS Examples <span class="hidden-xs text-muted">PHP</span>
						</a>
					</div>
					
				</div>
			</div>
		</nav> 
		<!-- /header -->         