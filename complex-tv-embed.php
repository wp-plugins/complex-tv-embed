<?php

/*
  Plugin Name: Complex TV Embed
  Version: 1.0
  Author: Pablo Mendez
  Author URI: http://www.complex.com
  Plugin URI: http://colabs.complex.com
  Description: WP plugin to help publishers with the ooyala video embed codes for their posts.
*/


// Add Shortcode
add_shortcode( 'complextv', 'complextv_shortcode' );

function complextv_shortcode( $atts, $content ) {

  // Attributes
  extract( shortcode_atts(
      array(
        'sitename' => get_option( 'ooyala_embed_site_name' ),
        'contentid' => '',
        'playerid' => get_option( 'ooyala_embed_player_id' ),
        'adsetid' => get_option( 'ooyala_embed_adset_id' ),
        'width' => get_option( 'ooyala_embed_width' ),
        'height' => get_option( 'ooyala_embed_height' ),
        'keywords' => get_option( 'ooyala_embed_keywords' )
      ), $atts )
  );

  $ovideo =  '<script src="http://cdnl.complex.com/tv/js/complexEmbed.min.js"></script>
                <script src="http://player.ooyala.com/v3/'.$playerid.'">
                </script>'
    . '<div id="ooyalaplayer'. $contentid .'" style="width:'.$width.'px;height:'.$height.'px;"></div>
                <script>'.'
              ComplexEmbed.Application.initialize({cId: "'.$contentid.'",adSetCode: "'. $adsetid . '",site: "' . $sitename .'",kw: "'. $keywords .'"});
                </script><noscript>
                <div>Please enable Javascript to watch this video</div></noscript>';
   return $ovideo;


}

add_action( 'admin_menu', 'complex_tv_embed_admin_actions' );
function complex_tv_embed_admin_actions() {
  // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
  add_options_page( 'Complex TV Embed', 'Complex TV Embed', 'manage_options', 'complextv_embed', 'complextv_createembed_admin' );
}

function complextv_createembed_admin() { ?>
  <div class="wrap">
    <?php screen_icon(); ?>

    <form action="options.php" method="post" class="form-actions">
      <?php settings_fields( 'complextv_embed_options' ); ?>
      <?php do_settings_sections( 'complextv_embed' ); ?>
      <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
  </div>

  <?php
}


add_action( 'admin_init', 'complextv_embed_admin_init' );

function complextv_embed_admin_init() {
  //register_setting( $option_group, $option_name, $sanitize_callback );
  register_setting( 'complextv_embed_options', // $option_group
    'complextv_embed_options', // $option_name
    'complextv_embed_validate_options' //$sanitize_callback
  );

  //section
  //add_settings_section( $id, $title, $callback, $page );
  add_settings_section( 'complextv_embed_main', // $id
    '<h2>ComplexTV Embed - Settings</h2>', // $title
    'complextv_embed_section_text', // $callback
    'complextv_embed' // $page
  );

  //fields settings.
  //add_settings_field( $id, $title, $callback, $page, $section, $args );
  add_settings_field( 'ooyala_embed_site_name', // $id
    'Site Name',  // $$title
    'ooyala_embed_site_name_setting_input', // $callback
    'complextv_embed', // $page
    'complextv_embed_main' // $section
  );

  //add_settings_field( $id, $title, $callback, $page, $section, $args );
  add_settings_field( 'ooyala_embed_player_id', // $id
    'Player ID', // $title
    'ooyala_embed_player_id_setting_input', // $callback
    'complextv_embed', // $page
    'complextv_embed_main' //$section
  );

  //add_settings_field( $id, $title, $callback, $page, $section, $args );
  add_settings_field( 'ooyala_embed_adset_id', // $id,
    'AdSet ID', //  $title
    'ooyala_embed_adset_id_setting_input', // $callback
    'complextv_embed', // $page
    'complextv_embed_main' // $section
  );

  //addd_settings_field( $id, $title, $callback, $page, $section, $args );
  add_settings_field( 'ooyala_embed_width',
    'Width',
    'ooyala_embed_width_setting_input',
    'complextv_embed',
    'complextv_embed_main' );

  //add_settings_field( $id, $title, $callback, $page, $section, $args );
  add_settings_field( 'ooyala_embed_height',
    'Height',
    'ooyala_embed_height_setting_input',
    'complextv_embed',
    'complextv_embed_main' );
}

// Draw the section header
function complextv_embed_section_text() {
  echo "<h2>Default Shortcode Values</h2>";
  echo "<p>These are the default values that will be used if they are left out of the Complex TV shortcode.</p>";
}

function ooyala_embed_site_name_setting_input() {
  $options = get_option( 'complextv_embed_options' );
  $text_string = $options['ooyala_embed_site_name'];
  // echo the field
  echo "<input id='ooyala_embed_site_name' name='complextv_embed_options[ooyala_embed_site_name]' type='text' value='$text_string' />";
}

function ooyala_embed_player_id_setting_input() {
  $options = get_option( 'complextv_embed_options' );
  $text_string = $options['ooyala_embed_player_id'];
  // echo the field
  echo "<input id='ooyala_embed_player_id' name='complextv_embed_options[ooyala_embed_player_id]' type='text' value='$text_string' />";
}

function ooyala_embed_adset_id_setting_input() {
  $options = get_option( 'complextv_embed_options' );
  $text_string = $options['ooyala_embed_adset_id'];
  // echo the field
  echo "<input id='ooyala_embed_adset_id' name='complextv_embed_options[ooyala_embed_adset_id]' type='text' value='$text_string' />";
}

function ooyala_embed_width_setting_input() {
  $options = get_option( 'complextv_embed_options' );
  $text_string = $options['ooyala_embed_width'];
  // echo the field
  echo "<input id='ooyala_embed_width' name='complextv_embed_options[ooyala_embed_width]' type='number' value='$text_string' />";
}

function ooyala_embed_height_setting_input() {
  $options = get_option( 'complextv_embed_options' );
  $text_string = $options['ooyala_embed_height'];
  // echo the field
  echo "<input id='ooyala_embed_height' name='complextv_embed_options[ooyala_embed_height]' type='number' value='$text_string' />";
}

function complextv_embed_validate_options( $input ) {

  $fields = array('ooyala_embed_site_name', 'ooyala_embed_player_id', 'ooyala_embed_adset_id' );
  $integerFields = array('ooyala_embed_width', 'ooyala_embed_height');

  foreach ($fields as $key => $value) {
    $valid[ $value ] = preg_replace( '/[^a-zA-Z|0-9]/', '', $input[$value] );

    if( $valid[ $value ] != $input[ $value ] ) {
      // add_settings_error( $setting, $code, $message, $type );
      add_settings_error(
        $value, // $setting
        'complextv_embed_texterror', // $code
        'Incorrect value entered!', // $message
        'error' // $type
      );
    }
  }
  
  //Validate integers.
  foreach ($integerFields as $key => $value) {
     $valid[ $value ] = preg_replace( '/[^0-9]/', '', $input[$value] );
 
     if( $valid[ $value ] != $input[ $value ] ) {
        // add_settings_error( $setting, $code, $message, $type );
        add_settings_error(
          $value, // $setting
          'complextv_embed_texterror', // $code
          'Width and Height must be numbers!', // $message
          'error' // $type
        );
     }
  }

  return $valid;
}
