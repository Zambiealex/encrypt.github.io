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
		<link rel="stylesheet" type="text/css" href="<?php template::stylesheet('admin');?>" />
        <script type="text/javascript" src="<?php template::javascript('jquery');?>"></script>
		<script type="text/javascript" src="<?php template::javascript('admin');?>"></script>
        <link rel="shortcut icon" href="<?php page::render( $site->favicon );?>" type="image/x-icon">
</head>
<body>
<div class="wrapper">
	<div class="header">
    				<a href="<?php page::render(url::generate('panel')); ?>" class="logo">
           					<img src="<?php page::render($page->data->logo); ?>" width="200" height="100" alt="MuroArgento" /> 
                    </a>
                    <?php if( $user->isLoggedIn() && $user->hasPermission('admin') ) : ?>
                    <nav>
                    	<ul>
                        <li> <?php lang::output('text_welcome'); ?> <span class="welcome"><?php page::render($user->data()->username); ?></span></li>
                        <li> <a href="<?php page::render(url::generate('panel/posts')); ?>"> <?php lang::output('nav_posts'); ?> </a> </li>
                        <li> <a href="<?php page::render(url::generate('panel/categories')); ?>"> <?php lang::output('nav_categorys'); ?> </a> </li>
                        <li> <a href="<?php page::render(url::generate('panel/advertising')); ?>"> <?php lang::output('nav_advertising'); ?></a> </li>
                        <li> <a href="<?php page::render(url::generate('panel/reports')); ?>"> <?php lang::output('nav_reports'); ?> </a> </li>
                        <li> <a href="<?php page::render(url::generate('panel/users')); ?>"> <?php lang::output('nav_users'); ?> </a> </li>
                        <li> <a href="<?php page::render(url::generate('panel/langs')); ?>"><?php lang::output('nav_langs'); ?></a> </li>
                        <li> <a href="<?php url::action('access', 'logout'); ?>"> <?php lang::output('nav_logout'); ?> </a> </li>
						</ul>
                    </nav>
                    <?php endif; ?>
                    <div class="clearfix"></div>
    </div>
</div>