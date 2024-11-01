<?php 
/*
Plugin Name: WP easy and supper Preloader
Plugin URI: http://prowpexpert.com/
Description: This plugin add preloader in your wordpress site.
Author: md sohel
Author URI: paisleyfarmersmarket.ca/sohels/
Version: 1.0
*/



/* Adding Latest jQuery from Wordpress */
function FRE_STYL_PRELOADER_PLUGIN_WP() {
	wp_enqueue_script('jquery');
}
add_action('init', 'FRE_STYL_PRELOADER_PLUGIN_WP');


/*Some Set-up*/
define('FRE_STYL_PRELOADER_PLUGIN_WP', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );



function plugin_function_loader_css_and_js_files() {
	wp_enqueue_script('load-styl-preloader-pace-main', FRE_STYL_PRELOADER_PLUGIN_WP.'js/pace.min.js', array('jquery'));
	wp_enqueue_script('load-styl-preloader-global-active', FRE_STYL_PRELOADER_PLUGIN_WP.'js/active.js', array('jquery'));
	wp_enqueue_style('load-styl-preloader-main-css', FRE_STYL_PRELOADER_PLUGIN_WP.'css/main.css');
}
add_action('wp_enqueue_scripts', 'plugin_function_loader_css_and_js_files');


function add_loadpreloader_options_framwrork()  
{  
	add_options_page('Preloader Settings', 'Preloader Settings', 'manage_options', 'preloader-settings','loadppreloader_options_framwrork');  
}  
add_action('admin_menu', 'add_loadpreloader_options_framwrork');


add_action( 'admin_enqueue_scripts', 'prow_load_styl_add_color_picker' );
function prow_load_styl_add_color_picker( $hook ) {
 
    if( is_admin() ) {
     
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}


if ( is_admin() ) : // Load only if we are viewing an admin page






function prow_preloader_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'pro_loadpreloader_p_options', 'pro_loadpreloader_options', 'pro_loadpreloader_validate_options' );
}

add_action( 'admin_init', 'prow_preloader_register_settings' );

// Default options values
$pro_loadpreloader_options = array(
	'preloader_bg_color' => '#000',
	'preloader_color' => '#fff',
	'preloader_type' => 'plane',
	'preloader_animation_type' => 'burbur'
);

// Store values in array
$preloader_type = array(
	'rotating_plane' => array(
		'value' => 'plane',
		'label' => 'Rotating Plane'
	),
	'double_bounce' => array(
		'value' => 'bounce',
		'label' => 'Double Bounce'
	),
	'wave_preload' => array(
		'value' => 'wave',
		'label' => 'Wave'
	),
	'wandering_cubes' => array(
		'value' => 'cubes',
		'label' => 'wandering-cubes'
	),
	'pulse_preload' => array(
		'value' => 'pulse',
		'label' => 'pulse'
	),
	'chasing_dots' => array(
		'value' => 'chasing',
		'label' => 'chasing-dots'
	),
	'three_bounce' => array(
		'value' => 'three_bounce',
		'label' => 'three bounce'
	),
	'circle_style' => array(
		'value' => 'circle',
		'label' => 'Spinning Circle'
	),
	'cube_grid' => array(
		'value' => 'cube_grid',
		'label' => 'Cube grid'
	),
	'wordpress' => array(
		'value' => 'wordpress',
		'label' => 'Circle'
	),
	'fadin_circle' => array(
		'value' => 'fading_circle',
		'label' => 'Fading Circle'
	),
);

// Store values in array
$preloader_animation_type = array(
	'burbur_shop_animation' => array(
		'value' => 'burbur',
		'label' => 'Burbur Shop'
	),
	'big_counter' => array(
		'value' => 'bc',
		'label' => 'Big Counter'
	),
	'bounce_animation' => array(
		'value' => 'bounce',
		'label' => 'Bounce'
	),
	'atom_animation' => array(
		'value' => 'atom',
		'label' => 'Center Atom'
	),
	'center_cercal' => array(
		'value' => 'center_cercal',
		'label' => 'Center circle'
	),
	'center_radar' => array(
		'value' => 'center_radar',
		'label' => 'center-radar'
	),
	'center_simple' => array(
		'value' => 'center_simple',
		'label' => 'center Simple'
	),
	'corner_indicator' => array(
		'value' => 'corner_indicator',
		'label' => 'Corner Indicator'
	),
	'fill_left' => array(
		'value' => 'fill_left',
		'label' => 'Fill Left'
	),
	'flash' => array(
		'value' => 'flash',
		'label' => 'Flash'
	),
	'flat_top' => array(
		'value' => 'flat_top',
		'label' => 'Flat Top'
	),
	'loading_bar' => array(
		'value' => 'loading_bar',
		'label' => 'loading bar'
	),
	'mac_osx' => array(
		'value' => 'mac_osx',
		'label' => 'Mac Osx'
	),
	'minimal' => array(
		'value' => 'minimal',
		'label' => 'Minimal'
	),
);



// Function to generate options page
function loadppreloader_options_framwrork() {
	global $pro_loadpreloader_options, $preloader_type, $preloader_animation_type;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	
	<h2>Custom Scrollbar Options</h2>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>
	
	<?php settings_fields( 'pro_loadpreloader_p_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	
	
		<tr valign="top">
			<th scope="row"><label for="background_color">Preloader Animation</label></th>
			<td>
				<?php foreach( $preloader_animation_type as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="pro_loadpreloader_options[preloader_animation_type]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['preloader_animation_type'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
			</td>
		</tr>
	
		<tr valign="top">
			<th scope="row"><label for="background_color">Preloader Style</label></th>
			<td>
				<?php foreach( $preloader_type as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="pro_loadpreloader_options[preloader_type]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['preloader_type'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="preloader_bg_color">Preloader Background</label></th>
			<td>
				<input id="preloader_bg_color" type="text" name="pro_loadpreloader_options[preloader_bg_color]" value="<?php echo stripslashes($settings['preloader_bg_color']); ?>" class="color-field" /><p class="description">Select preloader background color here. You can also add html HEX color code.</p>
			</td>
		</tr>	

		<tr valign="top">
			<th scope="row"><label for="preloader_color">Preloader color</label></th>
			<td>
				<input id="preloader_color" type="text" name="pro_loadpreloader_options[preloader_color]" value="<?php echo stripslashes($settings['preloader_color']); ?>" class="color-field" /><p class="description">Select preloader color here. You can also add html HEX color code.</p>
			</td>
		</tr>	

			
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}


function pro_loadpreloader_validate_options( $input ) {
	global $pro_loadpreloader_options, $preloader_type, $preloader_animation_type;

	$settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['preloader_bg_color'] = wp_filter_post_kses( $input['preloader_bg_color'] );
	$input['preloader_color'] = wp_filter_post_kses( $input['preloader_color'] );

		
	// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $preloader_type ) )

		

	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $preloader_animation_type ) )
		$input['layout_only'] = $prev;	
	
	return $input;
}


endif;  // EndIf is_admin()




function pace_animation_css_files() {?>

<?php global $pro_loadpreloader_options; $pro_loadpreloader_settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>

<?php if($pro_loadpreloader_settings['preloader_animation_type'] == 'bc') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-1', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-big-counter.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'bounce') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-2', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-bounce.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'atom') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-3', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-center-atom.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'center_cercal') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-center-circle.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'center_radar') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-center-radar.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'center_simple') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-center-simple.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'corner_indicator') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-corner-indicator.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'fill_left') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-fill-left.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'flash') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-flash.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'flat_top') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-flat-top.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'loading_bar') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-loading-bar.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'mac_osx') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-mac-osx.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_animation_type'] == 'minimal') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-animation-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-minimal.css'); ?>

	
<?php else : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-animation-1', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pace/pace-theme-barber-shop.css'); ?>

<?php endif; ?>


<?php
}
add_action( 'wp_enqueue_scripts', 'pace_animation_css_files' );






function global_background_color_change() {?>

<?php global $pro_loadpreloader_options; $pro_loadpreloader_settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>

<style type="text/css">
	div.pro_styl_preloader_overlay {background-color:<?php echo $pro_loadpreloader_settings['preloader_bg_color']; ?>}
</style>


<?php
}
add_action('wp_head', 'global_background_color_change');











/* Including all files */



function lazy_p_dynamic_preloader_html() {?>
	<?php global $pro_loadpreloader_options; $pro_loadpreloader_settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>
	
	
	<?php if($pro_loadpreloader_settings['preloader_type'] == 'bounce') : ?>
	

		
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		<div id="dounle_bounce" class="load_styl_spinner">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>
	</div>
	
	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wave') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		<div class="load_styl_spinner">
		  <div class="rect1"></div>
		  <div class="rect2"></div>
		  <div class="rect3"></div>
		  <div class="rect4"></div>
		  <div class="rect5"></div>
		</div>
	</div>


	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cubes') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		<div class="load_styl_spinner"></div>
	</div>

	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'pulse') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		 <div class="load_styl_spinner"></div>
	</div>


	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'chasing') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		<div class="load_styl_spinner">
		  <div class="dot1"></div>
		  <div class="dot2"></div>
		</div>
	</div>

	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'three_bounce') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		 <div class="load_styl_spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>
	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'circle') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		   <div class="load_styl_spinner">
			<div class="circle1 circle"></div>
			<div class="circle2 circle"></div>
			<div class="circle3 circle"></div>
			<div class="circle4 circle"></div>
			<div class="circle5 circle"></div>
			<div class="circle6 circle"></div>
			<div class="circle7 circle"></div>
			<div class="circle8 circle"></div>
			<div class="circle9 circle"></div>
			<div class="circle10 circle"></div>
			<div class="circle11 circle"></div>
			<div class="circle12 circle"></div>
		  </div>
	</div>


	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cube_grid') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>

		  <div class="load_styl_spinner">
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
			<div class="cube"></div>
		  </div>
	</div>



	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wordpress') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		  <div class="load_styl_spinner">
			<span class="inner-circle"></span>
		  </div>
	</div>

	<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'fading_circle') : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		   <div class="load_styl_spinner">
			<div class="circle1 circle"></div>
			<div class="circle2 circle"></div>
			<div class="circle3 circle"></div>
			<div class="circle4 circle"></div>
			<div class="circle5 circle"></div>
			<div class="circle6 circle"></div>
			<div class="circle7 circle"></div>
			<div class="circle8 circle"></div>
			<div class="circle9 circle"></div>
			<div class="circle10 circle"></div>
			<div class="circle11 circle"></div>
			<div class="circle12 circle"></div>
		  </div>
	</div>


	
	

	
<?php else : ?>
	
	<div class="pro_styl_preloader_container">
		<div class="pro_styl_preloader_overlay"></div>
		<div class="load_styl_spinner"></div>
	</div>

<?php endif; ?>
	

<?php

}
add_action('wp_footer', 'lazy_p_dynamic_preloader_html');



function FRE_STYL_PRELOADER_PLUGIN_WP_files() {?>

<?php global $pro_loadpreloader_options; $pro_loadpreloader_settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>


<?php if($pro_loadpreloader_settings['preloader_type'] == 'bounce') : ?>
		
	<?php wp_enqueue_style('load-styl-preloader-css-2', FRE_STYL_PRELOADER_PLUGIN_WP.'css/double-bounce.css'); ?>

<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wave') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-3', FRE_STYL_PRELOADER_PLUGIN_WP.'css/wave.css'); ?>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cubes') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-4', FRE_STYL_PRELOADER_PLUGIN_WP.'css/cubes.css'); ?>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'pulse') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/pulse.css'); ?>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'chasing') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/chasing-dots.css'); ?>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'three_bounce') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/three-bounce.css'); ?>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'circle') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/circle.css'); ?>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cube_grid') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/cube-grid.css'); ?>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wordpress') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/wordpress.css'); ?>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'fading_circle') : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-5', FRE_STYL_PRELOADER_PLUGIN_WP.'css/fading-circle.css'); ?>
	
<?php else : ?>
	
	<?php wp_enqueue_style('load-styl-preloader-css-1', FRE_STYL_PRELOADER_PLUGIN_WP.'css/rotating-plane.css'); ?>

<?php endif; ?>


	
	<?php
}
add_action( 'wp_enqueue_scripts', 'FRE_STYL_PRELOADER_PLUGIN_WP_files' );



function lazy_p_get_data_from_preloader_settings() {?>

<?php global $pro_loadpreloader_options; $pro_loadpreloader_settings = get_option( 'pro_loadpreloader_options', $pro_loadpreloader_options ); ?>

<?php if($pro_loadpreloader_settings['preloader_type'] == 'bounce') : ?>

	<style type="text/css">
		.double-bounce1, .double-bounce2 {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
	
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wave') : ?>	

	<style type="text/css">
		div.rect1, div.rect2, div.rect3, div.rect4, div.rect5 {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cubes') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'pulse') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'chasing') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'three_bounce') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'circle') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'cube_grid') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'wordpress') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>
<?php elseif($pro_loadpreloader_settings['preloader_type'] == 'fading_circle') : ?>	

	<style type="text/css">
		div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
	</style>

<?php else : ?>

<style type="text/css">
	div.load_styl_spinner {background-color:<?php echo $pro_loadpreloader_settings['preloader_color']; ?>}
</style>

<?php endif; ?>

<?php

}

add_action('wp_head', 'lazy_p_get_data_from_preloader_settings');




?>