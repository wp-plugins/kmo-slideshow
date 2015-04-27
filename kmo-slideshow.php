<?php
   /*
   Plugin Name: Kmo Slideshow
   Plugin URI: http://www.kmo.com.au/blog/wordpress-slideshow-plugin/
   Description: A plugin to display a gallery from a folder of images.
   Version: 1.0.0
   Author: KMO Design Pty Ltd
   Author URI: http://www.kmo.com.au
   License: GPL3
   */

new kmo_slideshow();

class kmo_slideshow{

	function kmo_slideshow() {		
		add_action( 'wp_enqueue_scripts', array( $this, 'kmo_styles' ) );
		add_shortcode( 'kmoslideshow', array( $this, 'kmo_shortcode' ) );
		add_action('plugins_loaded', array( $this, 'kmo_init' ) );
	}

	function kmo_init() {
		if ( !is_admin() ) add_filter( 'widget_text', array( $this, 'kmo_widget_shortcode' ), 11 );
	}
	
	function kmo_widget_shortcode( $content ) {
		if ( false === stripos( $content, '[kmoslideshow' ) ) {
			return $content;
		} else {
			return do_shortcode( $content );
		}
	}
	
	function kmo_styles() {
		wp_enqueue_style( 'kmo-slideshow-style', plugins_url( 'css/style.css', __FILE__ ) );
	}

	function kmo_scripts( $param, $handle ) {
		wp_enqueue_script( 'jquery-slides-script', plugins_url( 'js/jquery.slides.min.js', __FILE__ ), array( 'jquery' ) );
		echo '<script>jQuery(function(){ jQuery(\'#slides_'.$handle.'\').slidesjs({';
		echo 'start: '.$param["start"].',';
		echo 'width: '.$param["width"].',';
		echo 'height: '.$param["height"].',';
		echo 'navigation: false,';
		echo 'play: {auto: true, effect: "'.$param["effect"].'", interval: '.$param["interval"].'},';
		echo 'pagination: {active: false,effect: "'.$param["effect"].'"}';
		echo '});';
		echo '});</script>';
	}

	function file_array( $directory ) {
		$files = array();
		if( $handle = opendir( $directory ) ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				$ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
				if ( 'jpg' == $ext || 'png' == $ext ) {
					$files[] = $file;
				}
			}
			closedir( $handle );
		}
		sort( $files );
		return $files;
	}
				
	function kmo_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'folder'  => 'wp-content/uploads/',
			'width'   => 0,
			'padding' => 0,
			'border' => 0,
			'interval' => 2000,
			'pagination' => true,
			'effect' => 'slide',
		), $atts ) );

		$folder = rtrim( $folder, '/' );

		if ( !is_dir( $folder ) ) {
			return '<p style="color:red;"><strong>Error: </strong>Unable to find the directory ' . $folder . '</p>' ;
		}
	
		$pictures = $this->file_array( $folder );
		$NoP = count( $pictures );

		if ( 0 == $NoP ) {
			return '<p style="color:red;"><strong>Error: </strong>No images found in '. $folder . '</p>';
		}

        $start = rand(0, $NoP - 1);
        $handle = preg_replace("/[^a-zA-Z]/", "", $folder) . '_' . $start;

		// Image size required by SlidesJS
		$size = getimagesize( $folder . '/' . $pictures[0] );
		$pwidth = $size[0];
		$pheight = $size[1];
		// SlidesJS paramaters
		$param = array( 'start'=>$start, 'width'=>$pwidth, 'height'=>$pheight, 'interval'=>$interval, 'pagination'=>$pagination, 'paginationWidth'=>$NoP*16, 'effect'=>$effect );
		$this->kmo_scripts($param, $handle);

		$slideshow_code = '<div class="kmo_slideshow" style="';
		if ( 0 != $width )  $slideshow_code .= 'width:' . $width . 'px;';
		$slideshow_code .= 'border:' . $border . 'px solid #ddd;padding:' . $padding . 'px">';	
		
		$slideshow_code .= '<div id="slides_'.$handle.'">';
		
		for ( $idx = 0 ; $idx < $NoP ; $idx++ ) {	
			$slideshow_code .= '<img src="' . home_url( '/' ) . $folder . '/' . $pictures[ $idx ] . '"';
			$slideshow_code .= " width=\"$width\" height=\"$height\"";
			$slideshow_code .= ' alt="' . $pictures[ $idx ] . '" />' . "\n";
		}
		
		$slideshow_code .= '</div></div>' . "\n";
		
		return $slideshow_code;
	}
} 
?>