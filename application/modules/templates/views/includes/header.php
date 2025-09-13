<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo setting()->site_description; ?>" />
	<meta name="keywords" content="<?php echo setting()->seo_keywords; ?>">
	<meta name="author" content="Africa CDC" />
	<!-- Title -->
	<title><?php echo $title; ?></title>

	<!-- Favicon -->
    <link href="<?php echo base_url() ?>assets/img/favicon.png" rel="icon">

	<!-- Icons css -->
	<link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet">
    <!-- Select2 CSS and JS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-- Bootstrap css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
	
	<!-- Right-sidemenu css -->
	<link href="<?php echo base_url() ?>assets/plugins/sidebar/sidebar.css" rel="stylesheet">

	<!-- Style css -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>assets/css/style.css">

	<!-- Colors css -->
	<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>assets/css/colors/color.css">

	<!-- Horizontal css -->
	<link href="<?php echo base_url() ?>assets/css/horizontalmenu/horizontal-menu.css" rel="stylesheet">

	<!-- Skinmodes css -->
	<!-- <link href="<?php echo base_url() ?>assets/css/skin-modes.css" rel="stylesheet"> -->

	<!-- Darktheme css -->
	<!-- <link href="<?php echo base_url() ?>assets/css/style-dark.css" rel="stylesheet"> -->
    
    <link rel="stylesheet" type="text/css"
	href="https://cdn.datatables.net/v/dt/dt-1.13.1/b-2.3.3/b-html5-2.3.3/datatables.min.css" />
	
	<!-- DataTables Buttons CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" />
	
	<!-- DataTables Responsive CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" />
	
	<!-- DataTables Print Button CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap5.min.css" />

	<link href="<?php echo base_url() ?>assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
	<!-- Animations css -->

	<link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet">
	
	<!-- Highcharts -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/boost.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
	<script src="https://code.highcharts.com/modules/map.js"></script>
	


	<style>
		.select2-close-mask {
			z-index: 2099;
		}

		.select2-dropdown {
			z-index: 3051;
		}

		/* File Input Styling */
		input[type="file"]::-webkit-file-upload-button {
			visibility: hidden;
		}

		input[type="file"]::before {
			content: 'Click to Upload';
			display: inline-block;
		}
	
	</style>

</head>

<body class="main-body">
