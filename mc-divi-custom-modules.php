<?php 
/**
 * @package TY_Divi_Modules
 * @version 1.0.0
 */
/*
* Plugin Name: TY Divi Modules
* Plugin URI: 
* Version: 1.0.0
* Description: TY Divi Modules include some custom modules for Divi theme
* Author: Tony Yuan
* Author URI: 
* License: GPL2
* Text-domain: ty-dm
*/
/**
*
* Escape is someone tries to access directly
*
**/
if ( ! defined( 'ABSPATH') ) {
    exit;
}
/**
*
* Call the translation file
*
**/
add_action('init', 'ty_dm_load_translation_file');
function ty_dm_load_translation_file() {
    // relative path to WP_PLUGIN_DIR where the translation files will sit:
    $plugin_path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
    load_plugin_textdomain( 'ty-dm', false, $plugin_path );
}

/**
 * Main plugin class
 *
 * @since 0.1
 **/
class TY_Divi_Modules {
	
	/**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

	/**
	 * Class contructor
	 *
	 * @since 0.1
	 **/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		//call register settings function
		add_action( 'admin_init', array($this, 'ty_dm_settings' ));
		
	}

	/**
	 * Add administration menus
	 *
	 * @since 0.1
	 **/
	public function add_admin_pages() {

		//create new top-level menu
		add_submenu_page( 
            'options-general.php', 
            __( 'Divi Modules', 'ty-dm' ),
            __( 'Divi Modules', 'ty-dm' ),
            'manage_options', 
            'ty-dm-settings', 
            array( $this,'ty_dm_settings_page') 
        );
		
	}

	/**
	* Add administration page
	*
	* @since 0.1
	**/
	public function ty_dm_settings_page() {		
	
	// Set class property
    $this->options = get_option( 'ty_dm_option' );
    ?>
    <div class="wrap">
        <h1>Custom modules for Divi</h1>
        <form method="post" action="options.php">
        <?php
            // This prints out all hidden setting fields
            settings_fields( 'ty_dm_group' );
            do_settings_sections( 'ty-dm-settings' );
            submit_button();
        ?>
        </form>
    </div>
<?php }
	
	/**
     * Register and add settings
     *  Create a checkbox for each module
     */
    public function ty_dm_settings()
    {        
        register_setting(
            'ty_dm_group', // Option group
            'ty_dm_option' // Option name
        );
        
        add_settings_section(
            'ty_dm_section', // ID
            'Modules', // Title
            array( $this, 'print_section_info' ), // Callback
            'ty-dm-settings' // Page
        );  
        add_settings_field(
            'title', // ID
            'Title', // Title 
            array( $this, 'title_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        );
        add_settings_field(
            'choose_post', // ID
            'Selected items', // Title 
            array( $this, 'choose_post_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        );
        add_settings_field(
            'choose_product', // ID
            'Selected products', // Title 
            array( $this, 'choose_product_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        ); 
        add_settings_field(
            'carousel', // ID
            'Carousel', // Title 
            array( $this, 'carousel_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        ); 
        add_settings_field(
            'carousel_text', // ID
            'Carousel text', // Title 
            array( $this, 'carousel_text_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        );
       
        add_settings_field(
            'breadcrumb', // ID
            'Breadcrumb', // Title 
            array( $this, 'breadcrumb_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        ); 
        add_settings_field(
            'button_down', // ID
            'Button Down', // Title 
            array( $this, 'button_down_callback' ), // Callback
            'ty-dm-settings', // Page
            'ty_dm_section' // Section           
        );  
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Select the modules you want to activate :';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {   ?>
        <input type="checkbox" id="title" name="ty_dm_option[title]" value="1" <?php isset($this->options['title'] ) ? checked( $this->options['title'], 1, true ) : '' ?> />
    <?php  
    }
    public function choose_post_callback()
    {	?>
    	<input type="checkbox" id="choose_post" name="ty_dm_option[choose_post]" value="1" <?php isset($this->options['choose_post'] ) ? checked( $this->options['choose_post'], 1, true ) : '' ?> />
    <?php   
    }
    public function choose_product_callback()
    {	?>
    	<input type="checkbox" id="choose_product" name="ty_dm_option[choose_product]" value="1" <?php isset($this->options['choose_product'] ) ? checked( $this->options['choose_product'], 1, true ) : '' ?> />
    <?php  
    }
    public function carousel_callback()
    {	?>
    	<input type="checkbox" id="carousel" name="ty_dm_option[carousel]" value="1" <?php isset($this->options['carousel'] ) ? checked( $this->options['carousel'], 1, true ) : '' ?> />
    <?php  
    }
    public function carousel_text_callback()
    {   ?>
        <input type="checkbox" id="carousel_text" name="ty_dm_option[carousel_text]" value="1" <?php isset($this->options['carousel_text'] ) ? checked( $this->options['carousel_text'], 1, true ) : '' ?> />
    <?php  
    }
    public function breadcrumb_callback()
    {   ?>
        <input type="checkbox" id="breadcrumb" name="ty_dm_option[breadcrumb]" value="1" <?php isset($this->options['breadcrumb'] ) ? checked( $this->options['breadcrumb'], 1, true ) : '' ?> />
    <?php  
    }
    public function button_down_callback()
    {   ?>
        <input type="checkbox" id="button_down" name="ty_dm_option[button_down]" value="1" <?php isset($this->options['button_down'] ) ? checked( $this->options['button_down'], 1, true ) : '' ?> />
    <?php  
    }
}

if( is_admin() )
$my_settings_page = new TY_Divi_Modules();

add_action('after_setup_theme', 'include_modules');

/**
 * Include each module, please note the option, the folder and the file should have the same name
 */
function include_modules() {
	$options = get_option( 'ty_dm_option' );
    if($options) {
        foreach($options as $option => $value) {
        	require_once(plugin_dir_path( __FILE__ ) . 'modules/'. $option .'/'. $option .'.php');
        }
    }
}
