<?php
 
/**
 * The main plugin controller
 */
class fotoexposeController
{
    /**
     * the class constructor
     */
    
     public $html;
     
    public function __construct()
	{
		if( !is_admin() ):
			add_action( 'wp', array( $this, 'init' ) );
		endif;
	}
	 
	/**
	 * callback for the 'wp' action
	 *
	 * In this function, we determine what WordPress is doing and add plugin actions depending upon the results.
	 * This helps to keep the plugin code as light as possible, and reduce processing times.
	 *
	 * @package MVC Example
	 * @subpackage Main Plugin Controller
	 *
	 * @since 0.1
	 */
	public function init()
	{ 
		//actives when short code is found
		add_shortcode( 'fotoexpose', array( $this,'fe_shortcode' ) );
		
		wp_enqueue_style( 'fecss', plugins_url('../css/fe_gallery.css', __FILE__) );
	
		wp_enqueue_script( 'fe_plugin', plugins_url('../js/jquery.fotoexpose.min.js', __FILE__), array('jquery'),'',true);
		
		wp_enqueue_script( 'fe_javascript', plugins_url('../js/fe_javascript.min.js', __FILE__),'',true);
	
	}
	
	public function fe_shortcode( $atts, $content = null ) {
			//require_once our model
			require_once( 'models/fotoexpose-model.php' );
			
			//instantiate the model
			$fpModel = new fotoexposeModel($content);
			
			//get the list of image in the short code
			$shortcode_images = $fpModel->fp_return_image_list();
			
			require_once( 'views/fotoexpose-view.php' );
			
			return fp_view_gallery::render($shortcode_images);
		
	}
	
}
 
$fotoexpose = new fotoexposeController;

?>