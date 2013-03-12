<?php

require(dirname(__FILE__) . "/classes/epimetheus_nav_walker.php");

class EpimetheusTheme
{
	public function initialize() {
		register_nav_menu( 'primary', 'Primary Menu' );
	}

	public function load_styles() {
		wp_enqueue_style('foundation',  content_url('themes/epimetheus/css/foundation.css'));
	}

	public function initialize_widgets() {
		register_sidebar( array(
			'name' => __( 'Main Sidebar', 'epimetheus' ),
			'id' => 'sidebar-1',
			'class' => 'side-nav',
			'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'epimetheus' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
}

$epimetheus = new EpimetheusTheme();
add_action('after_setup_theme', array($epimetheus, 'initialize'));
add_action('widgets_init', array($epimetheus, 'initialize_widgets'));
add_action('wp_enqueue_scripts', array($epimetheus, 'load_styles') );

?>