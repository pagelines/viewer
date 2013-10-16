<?php
/*
	Section: Gallery
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: An advanced, touch and swipe enabled image and rich media Gallery.
	Class Name: PLGallery
	Edition: pro
	Filter: slider, gallery
*/


class PLGallery extends PageLinesSection {

	var $default_limit = 2;

	function section_styles(){
		wp_enqueue_script('royalslider', $this->base_url.'/royalslider/jquery.royalslider.min.js', array('jquery'));
		wp_enqueue_style( 'royalslider-css', $this->base_url.'/royalslider/royalslider.css');
		wp_enqueue_style( 'royalslider-theme', $this->base_url.'/royalslider/skins/default/rs-default.css');
		
	}
	
	function section_head(){
		?>
		
		 <script>
		      jQuery(document).ready(function(jQuery) {
		 		jQuery('<?php echo $this->prefix();?> .pl-gallery').royalSlider({
			
					autoScaleSlider: true,
					autoHeight: true,
					arrowsNav: true,
					fadeinLoadedSlide: true,
					controlNavigation: 'thumbnails',
	
					
					thumbs: {
						autoCenter: true,
						fitInViewport: false,
						orientation: 'horizontal',
						spacing: 10,
						paddingBottom: 0
					},
					keyboardNavEnabled: true,
					imageScaleMode: 'fill',
					imageAlignCenter:true,
					slidesSpacing: 0,
					loop: false,
					loopRewind: true,
					numImagesToPreload: 3,
					video: {
					 autoHideArrows:true,
					 autoHideControlNav:false,
					 autoHideBlocks: true
					}, 
					
					autoHeight: true,
					controlNavigation: 'thumbnails',
					})
		})

		    </script>
		
		
		<?php
	}

	function section_opts(){
		$options = array();

		$options[] = array(

			'title' => __( 'Gallery Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'gallery_count',
					'type' 			=> 'count_select',
					'count_start'	=> 1,
					'count_number'	=> 20,
					'default'		=> 3,
					'label' 	=> __( 'Number of Items to Configure', 'pagelines' ),
				),
				array(
					'key'			=> 'gallery_title',
					'type' 			=> 'text',
					'label' 	=> __( 'Gallery Title', 'pagelines' ),
				),
				array(
					'key'			=> 'gallery_desc',
					'type' 			=> 'textarea',
					'label' 	=> __( 'Gallery Description', 'pagelines' ),
				),
			)

		);

		$slides = ($this->opt('gallery_count')) ? $this->opt('gallery_count') : $this->default_limit;
	
		for($i = 1; $i <= $slides; $i++){

			$opts = array();
			
			$opts[] = array(
				'key'		=> 'gallery_image_'.$i,
				'label'		=> __( 'Slide Image', 'pagelines' ),
				'type'		=> 'image_upload',
			);

			$opts[] = array(
				'key'		=> 'gallery_url_'.$i,
				'label'	=> __( 'Slide Video URL (Vimeo or Youtube)', 'pagelines' ),
				'type'	=> 'text', 
				'help'	=> __('<strong>Ex.</strong><br/ > http://www.youtube.com/watch?v=rNYiWNLtk5A <br />
				http://vimeo.com/6763069', 'pagelines')
			);

			$options[] = array(
				'title' 	=> __( 'Gallery Item ', 'pagelines' ) . $i,
				'type' 		=> 'multi',
				'opts' 		=> $opts,

			);

		}

		return $options;
	}
	
	function the_media(){
		
		$num = ($this->opt('gallery_count')) ? $this->opt('gallery_count') : $this->default_limit;
		$out = array();
		
		for($i = 1; $i <= $num; $i++):
			
			$title = ($this->opt('gallery_title_'.$i)) ? $this->opt('gallery_title_'.$i) : ''; 
			$url = ($this->opt('gallery_url_'.$i)) ? $this->opt('gallery_url_'.$i) : '';
			$img = ($this->opt('gallery_image_'.$i)) ? $this->opt('gallery_image_'.$i) : '';
			
			if($url != '' || $img != ''){
				$out[] = array(
					'title'	=> $title, 
					'url'	=> $url, 
					'img'	=> $img
				);
			}
			 
			
		endfor;
		
		if( empty($out) ){
			$out[] = array(
				'title'	=> 'Gallery', 
				'img'	=>	$this->base_url.'/sample1.jpg'
			);
			
			$out[] = array(
				'title'	=> 'Gallery', 
				'img'	=>	$this->base_url.'/sample2.jpg'
			);
		}
		
		return $out;
	}

   function section_template( ) {
	
		$title = ( $this->opt('gallery_title') ) ? sprintf( '<h2 class="pl-gallery-title" data-sync="gallery_title">%s</h2>', $this->opt('gallery_title') ) : '';
		$desc = ( $this->opt('gallery_desc') ) ? sprintf( '<div class="pl-gallery-desc">%s</div>', $this->opt('gallery_desc') ) : '';
	
		
	 ?>
	
	<div class="pl-gallery-wrap">
		<?php printf('<div class="pl-gallery-details">%s%s</div>', $title, $desc); ?>
		<div id="pl-gallery" class="pl-gallery royalSlider videoGallery rsDefault">
			<?php foreach($this->the_media() as $m): 
				
				$vid_url = (isset( $m['url'] ) &&  $m['url'] != '') ? sprintf('data-rsVideo="%s"', $m['url']) : ''; ?>

				<div class="pl-gallery-slide">
					<img class="rsImg" <?php echo $vid_url;?> src="<?php echo $m['img'];?>"/>
					<span class="rsTmb">
						<div class="video-nav-img">
							<img class="theRsImg" src="<?php echo $m['img'];?>" /> 
						</div>
					</span>
				</div>
			<?php endforeach; ?>
		
		</div>
	</div>

<?php }


}