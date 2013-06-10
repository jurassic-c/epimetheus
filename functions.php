<?php

require(dirname(__FILE__) . "/hybrid-core/hybrid.php");
new Hybrid();

require(dirname(__FILE__) . "/classes/epimetheus_nav_walker.php");

class EpimetheusTheme
{
	public $child_theme_loaded = False;
	public $child_theme_name = "";
	public $child_theme_directory = "";
	public $load_styles = True;

	public function initialize() {
		register_nav_menu( 'primary', 'Primary Menu' );
		$this->child_theme_name = get_option('epimetheus_init_child');
		$this->load_styles = get_option('epimetheus_init_load_styles', True);
		if($this->child_theme_name) {
			$this->child_theme_loaded = True;
			$this->child_theme_directory = dirname(dirname(__FILE__))."/".$this->child_theme_name;
		}
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

		register_sidebar( array(
			'name' => __( 'Footer Bar', 'epimetheus' ),
			'id' => 'sidebar-2',
			'class' => 'side-nav',
			'description' => __( 'Appears in the footer', 'epimetheus' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	public function parse_shortcode_content( $content ) {

	    /* Parse nested shortcodes and add formatting. */
	    $content = trim( wpautop( do_shortcode( $content ) ) );

	    /* Remove '</p>' from the start of the string. */
	    if ( substr( $content, 0, 4 ) == '</p>' )
	        $content = substr( $content, 4 );

	    /* Remove '<p>' from the end of the string. */
	    if ( substr( $content, -3, 3 ) == '<p>' )
	        $content = substr( $content, 0, -3 );

	    /* Remove any instances of '<p></p>'. */
	    $content = str_replace( array( '<p></p>' ), '', $content );

	    return $content;
	}

	public function foundation_column($atts, $content=NULL) {
		if($content == null) return '';


		$atts = shortcode_atts(array(
			'large' => '',
			'small' => '',
			'push' => '',
			'pull' => '',
			'large_centered' => false,
			'small_centered' => false,
			'large_offset' => '',
			'small_offset' => '',
			'class' => '',
			'style' => '',
			'p' => 'true',
		), $this->cleanup_shortcode_atts($atts));
		extract($atts);

		$content = $this->parse_shortcode_content( $content );

		$out = '<div class="columns';
		if( $large || $small ){
			if($large)$out .= ' large-' . $large;
			if($small)$out .= ' small-' . $small;
		} else {
			if($small)$out .= ' small-12' . $small;
		}
		if($push)$out .= ' push-' . $push;
		if($pull)$out .= ' pull-' . $pull;
		if($large_centered)$out .= ' large-centered';
		if($small_centered)$out .= ' small-centered';
		if($large_offset)$out .= ' large-offset-' . $large_offset;
		if($small_offset)$out .= ' small-offset-' . $small_offset;
		if($class)$out .= ' ' . $class;
		$out .= '"';
		if($style)
			$out .= 'style="'. $style .'"';
		$out .= '>';
		if ( $p == 'false' ) $content = preg_replace('#<p>|</p>#', '', $content);
		$out .= $content;
		$out .= '</div>';

		return $out;
	}

	public function foundation_row($atts, $content = null) {
		if($content == null) return '';

		extract(shortcode_atts(array(
			'class' => '',
			'style' => '',
			'p' => 'true',
		), $atts));

		$content = $this->parse_shortcode_content( $content );

		$out = '<div class="row';
		if($type)$out .= ' ' . $type;
		if($class)$out .= ' ' . $class;
		$out .= '"';
		if($style)
			$out .= 'style="'. $style .'"';
		$out .= '>';
		if ( $p == 'false' ) $content = preg_replace('#<p>|</p>#', '', $content);
		$out .= $content;
		$out .= '</div>';

		return $out;
	}

	public function cleanup_shortcode_atts($atts) {
		$atts_new = array();
		foreach ($atts as $key => $value) {
			if(is_numeric($key) && substr_count($value, "=")){
				list($key,$value) = explode("=", $value);
				$atts_new[str_replace("-", "_", $key)] = $value;
			}
			$atts_new[$key] = $value;
		}
		return $atts_new;
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
add_action('after_setup_theme', array($epimetheus, 'initialize'), 0);
add_action('widgets_init', array($epimetheus, 'initialize_widgets'));
add_action('wp_enqueue_scripts', array($epimetheus, 'load_styles'), 10 );
add_shortcode('column', array($epimetheus, 'foundation_column'));
add_shortcode('column_inner', array($epimetheus, 'foundation_column'));
add_shortcode('column_wrapper', array($epimetheus, 'foundation_column'));
add_shortcode('column_outer', array($epimetheus, 'foundation_column'));
add_shortcode('row', array($epimetheus, 'foundation_row'));
add_shortcode('row_inner', array($epimetheus, 'foundation_row'));
add_shortcode('row_outer', array($epimetheus, 'foundation_row'));
add_shortcode('row_wrapper', array($epimetheus, 'foundation_row'));

?>