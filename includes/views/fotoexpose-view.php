<?php
 
if( !class_exists( 'fp_view_gallery') ):
 
    class fp_view_gallery {
        
        public static function render($thumbs) {
        
        	$playgif = plugins_url('../images/play.gif', __FILE__);
        	
        	$loading =  plugins_url('../images/loading.gif', __FILE__);
       
		   $html = "<div id=\"fe-container\">
			<div id=\"fe-fotobox\">
				<div id=\"fe-thumbs\">
					<div>$thumbs</div>
				</div>
				<div id=\"fe-location\">
					<div id=\"fe-current\">&nbsp;</div>
				</div>
				<div id=\"fe-toolbar-left\">
					<div id=\"fe-previous\" class=\"fe-button-class\">Previous</div>
					<div id=\"fe-previous-image\" class=\"fe-button-class fe-prev-next\">&lt;</div>
				</div><div id=\"fe-toolbar-center\">
					<div id=\"fe-play\" class=\"fe-button-class\">
						<img src=\"$playgif\" alt=\"playing\" class=\"fe-playing\" /><span id=\"fe-playtext\">Play</span>
					</div>
				</div><div id=\"fe-toolbar-right\">
					<div id=\"fe-more\" class=\"fe-button-class\">More</div>
					<div id=\"fe-next-image\" class=\"fe-button-class fe-prev-next\">&gt;</div>
				</div>
				<div id=\"fe-viewer\" class=\"fe-loader\" style=\"background-image:url($loading)\" >
					<img src=\"\" id=\"fe-largePhoto\" class=\"fe-largeshadow\"/>
				</div>
			</div></div>";
			
			return $html;
		
        }
    }
endif;
?>