<?php

require(dirname(__FILE__) . "/classes/epimetheus_nav_walker.php");

class EpimetheusTheme
{
	public $child_theme_loaded = False;
	public $child_theme_name = "";
	public $load_styles = True;

	public function initialize() {
		register_nav_menu( 'primary', 'Primary Menu' );
		$this->child_theme_name = get_option('epimetheus_init_child');
		$this->load_styles = get_option('epimetheus_init_load_styles', True);
		if($this->child_theme_name) $this->child_theme_loaded = True;
		$this->_delete_options();
	}

	public function load_styles() {
		if(!$this->load_styles) return;
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

	protected function _delete_options() {
		$opts = array(
			'epimetheus_init_child',
			'epimetheus_init_load_styles'
			);
		foreach($opts as $option) {
			delete_option($options);
		}
	}
}

if(!function_exists('epimetheus_init_option')) {
	function epimetheus_init_option($option_name, $value) {
		add_option('epimetheus_init_' . $option_name);
		update_option('epimetheus_init_' . $option_name, $value);
	}
}

$epimetheus = new EpimetheusTheme();
add_action('after_setup_theme', array($epimetheus, 'initialize'));
add_action('widgets_init', array($epimetheus, 'initialize_widgets'));
add_action('wp_enqueue_scripts', array($epimetheus, 'load_styles') );

?>