<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
        <meta name="distribution" content="global">
        <meta name="keywords" content="<?php page::render($site->tags); ?>" />
        <meta http-equiv="description" content="<?php page::render($site->description); ?>" />
        <title><?php page::render($title); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php template::stylesheet('normalize'); ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php template::stylesheet('pottus');?>"/>
        <script type="text/javascript" src="<?php template::javascript('jquery');?>"></script>
		<script type="text/javascript" src="<?php template::javascript('pottus');?>"></script>
        <script type="text/javascript" src="<?php template::javascript('jquery.timeago');?>"></script>
        <script type="text/javascript" src="<?php template::javascript('jquery.tmpl.min');?>"></script>
        <link rel="shortcut icon" href="<?php page::render( $site->favicon );?>" type="image/x-icon">
</head>
<body>

<div class="wrapper clearfix">
	<div class="header clearfix">    				
    				<a href="<?php page::render(url::generate()); ?>" class="logo">
           					<img src="<?php page::render($page->data->logo); ?>" width="200" height="100" alt="MuroArgento" /> 
                    </a>
                    <div class="footer clearfix">
                     		<?php page::render($copyright); ?>
            		</div>
                    <div class="clearfix"></div>
    </div>