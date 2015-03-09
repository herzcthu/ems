<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="images/favicon.html">
		<title><?php echo $page_title.' | '.lang('common_website_name');?></title>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
		<link href="<?php echo base_url('asset/js/bootstrap/dist/css/bootstrap.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/fonts/font-awesome-4/css/font-awesome.min.css');?>" rel="stylesheet" >
		<link href="<?php echo base_url('asset/js/bootstrap.wysihtml5/src/bootstrap-wysihtml5.css');?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url('asset/js/datepicker/css/datepicker.css');?>" rel="stylesheet" type="text/css">
		<!--[if lt IE 9]>
		  <script src="<?php echo base_url('asset/js/html5shiv.js');?>"></script>
		  <script src="<?php echo base_url('asset/js/respond.min.js');?>"></script>
		<![endif]-->
	<?php
		if(isset($css) && is_array($css))
		{
			foreach ($css as $key => $value) 
			{
				echo '<link href="'.base_url('asset/'.$value).'" rel="stylesheet">';	
			}
		}
	?>
		<link href='http://webfont.mmbay.org/css/?font=ayar,ayar takhu,ayar wagaung,ayar natdaw,ayar typewriter' rel='stylesheet' type='text/css'/> 
		<link href="<?php echo base_url('asset/css/style.css');?>" rel="stylesheet" />	
	</head>
	<body>