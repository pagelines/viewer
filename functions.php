<?php

/* 
 * Setup/Load core framework functions
 */
require_once( dirname(__FILE__) . '/setup.php' );


/* 
 *  Set default featured image size and allow cropping
 */
add_theme_support( 'post-thumbnails' );
add_image_size( 'aspect-thumb', 900, 600, true );
add_image_size( 'basic-thumb', 400, 400, true );
add_image_size( 'landscape-thumb', 1000, 450, true );


function pagelines_head_scripts(){
	?>
	<script>
	jQuery(document).ready(function($) {

		jQuery(".smooth-scroll").on('click', function(e){		
			e.preventDefault();
			jQuery('html,body').animate({
				scrollTop: jQuery(this.hash).offset().top - 20
			}, 500);
		});
	});
	</script>	
<?php 		
}	

function pagelines_footer_scripts(){
	
	if( 
		( !isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '' ) 
		&& ( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ) 
	){
		
	}
}
?>