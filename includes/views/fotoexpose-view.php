<?php
 
if( !class_exists( 'fp_view_gallery') ):
 
    class fp_view_gallery {
        
        public static function render($thumbs) {
       
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
				</div><div id=\"fe-toolbar-right\">
					<div id=\"fe-play\" class=\"fe-button-class\">
						<img src=\"plugins_url('../images/play.gif', __FILE__)\" alt=\"playing\" class=\"fe-playing\" /><span id=\"fe-playtext\">Play</span>
					</div>
					<div id=\"fe-more\" class=\"fe-button-class\">More</div>
				</div>
				<div id=\"fe-viewer\" class=\"fe-loader\" style=\"background-image: url(plugins_url('../images/loading.gif', __FILE__));\" >
					<img src=\"\" id=\"fe-largePhoto\" class=\"fe-largeshadow\"/>
				</div>
			</div></div>";
			
			return $html;
		
        }
    }
endif;
?>