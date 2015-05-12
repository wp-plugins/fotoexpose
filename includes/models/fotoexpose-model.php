<?php
 
/**
 * The fotoexpose model
 */
 
if( !class_exists( 'fotoexposeModel' ) ):
    
    class fotoexposeModel {
        
        private $content;
        
        public function __construct($content)
        {
           //sets the variable to the content encapsulate in the shortcode
           $this->content = $content;
        }
 		
 		public function fp_return_image_list() {
 		
 			//start a domDocument to retive just image in the content
			$dom = new domDocument; 
			
			//add html tags to vaildate the content
			$dom->loadHTML('<html><body>'.$this->content.'</body></html>'); 
			
			$dom->preserveWhiteSpace = false; 
			
			//select only the image elements fromt the DOM
			$images = $dom->getElementsByTagName('img');
			
		
				$image_list = array();
				
				foreach($images as $image) {
				
					//creating an array of the image to find in the post
					array_push($image_list, $image->getAttribute('src'));
				
				}
				
				$args = array(

					'post_parent' => get_the_ID(),
					
					'post_type' => 'attachment'
				
				);
				
				$attachement_list = get_children( $args );
				
				$thumbs = '';
				
				if(is_array($attachement_list)) {
				
				foreach($attachement_list AS $attachment_id => $attachment) {
				
					$img_thumbs = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
					
					$img_medium = wp_get_attachment_image_src( $attachment_id, 'medium');
					
					$img_large = wp_get_attachment_image_src( $attachment_id, 'large');
					
					if( in_array($img_medium[0],$image_list) ) {
					
						$thumbs .= '<img src="'.$img_thumbs[0].'" fe-full="'.$img_large[0].'" width="'.$img_thumbs[1].'" height="'.$img_thumbs[2].'" alt="galleryphoto" class="fe-thumbs">';

						
					}
									
				}
				
				return $thumbs;
				
			}
			else {
			
				return false;
			
			}
			
 	}
 
}   
    
endif;
