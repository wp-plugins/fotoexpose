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
			
			$content = str_replace('<p>','', $this->content);
			
			$content = str_replace('</p>','', $content);
			
			//add html tags to vaildate the content
			$dom->loadHTML('<html><body>'.$content.'</body></html>'); 
			
			$dom->preserveWhiteSpace = false; 
			
			//select only the image elements fromt the DOM
			$images = $dom->getElementsByTagName('img');
			
		
			$image_list = array();
			
			foreach($images as $image) {
			
				//creating an array of the image to find in the post
				preg_match('/wp-image-(?P<id>\d+)/',$image->getAttribute('class'),$matches);
				
				array_push($image_list, $matches['id']);
			
			}
			
			$thumbs = '';
			
			if(is_array($image_list)) {
			
				foreach($image_list AS $list_key => $attachment_id) {
		
					$img_thumbs = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
				
					$img_medium = wp_get_attachment_image_src( $attachment_id, 'medium');
				
					$img_large = wp_get_attachment_image_src( $attachment_id, 'large');
				
					$thumbs .= '<img src="'.$img_thumbs[0].'" fe-full="'.$img_large[0].'" width="'.$img_thumbs[1].'" height="'.$img_thumbs[2].'" alt="galleryphoto" class="fe-thumbs">';
								
				}
			
				return $thumbs;
			
			}
			else {
		
				return false;
		
			}
			
 		}
 
}   
    
endif;
