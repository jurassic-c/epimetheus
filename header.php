<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="row site-header">
    	<div class="large-12 columns">

    		<? if(has_nav_menu('primary')) : ?>
	          	<? wp_nav_menu( array('theme_location'=>'primary','container_class'=>'menu nav-bar right', 'menu_class'=>'button-group', 'walker'=>new EpimetheusNavWalker) ) ?>
	          <? else : ?>
	          	<div class="menu nav-bar right">
	          		<ul class="button-group">
	          			<li><a class="button" href="/">Home</a></li>
	          			<? foreach(get_pages(array('parent'=>0, 'post_type'=>'page')) as $page) : ?>
	          				<li><a class="button" href="<?= $page->guid ?>"><?= $page->post_title ?></a></li>
	          			<? endforeach ?>
	          		</ul>
	          	</div>
	          <? endif ?>
      		<h1><span class="site-title"><?bloginfo('name')?></span></h1>
      		<span class="site-description"><?bloginfo('description')?></span>
      		<hr />
    	</div>
	</div>