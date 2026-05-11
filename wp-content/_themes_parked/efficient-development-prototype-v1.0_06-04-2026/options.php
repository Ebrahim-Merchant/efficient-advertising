<?php

/**

 * A unique identifier is defined to store the options in the database and reference them from the theme.

 */

function optionsframework_option_name() {



	// Change this to use your theme slug

	return 'options-framework-theme';

}



/**

 * Defines an array of options that will be used to generate the settings page and be saved in the database.

 * When creating the 'id' fields, make sure to use all lowercase and no spaces.

 *

 * If you are making your theme translatable, you should replace 'theme-textdomain'

 * with the actual text domain for your theme.  Read more:

 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain

 */



function optionsframework_options() {



	// Test data

	$test_array = array(

		'one' => __( 'One', 'theme-textdomain' ),

		'two' => __( 'Two', 'theme-textdomain' ),

		'three' => __( 'Three', 'theme-textdomain' ),

		'four' => __( 'Four', 'theme-textdomain' ),

		'five' => __( 'Five', 'theme-textdomain' )

	);



	// Multicheck Array

	$multicheck_array = array(

		'one' => __( 'French Toast', 'theme-textdomain' ),

		'two' => __( 'Pancake', 'theme-textdomain' ),

		'three' => __( 'Omelette', 'theme-textdomain' ),

		'four' => __( 'Crepe', 'theme-textdomain' ),

		'five' => __( 'Waffle', 'theme-textdomain' )

	);



	// Multicheck Defaults

	$multicheck_defaults = array(

		'one' => '1',

		'five' => '1'

	);



	// Background Defaults

	$background_defaults = array(

		'color' => '',

		'image' => '',

		'repeat' => 'repeat',

		'position' => 'top center',

		'attachment'=>'scroll' );



	// Typography Defaults

	$typography_defaults = array(

		'size' => '15px',

		'face' => 'georgia',

		'style' => 'bold',

		'color' => '#bada55' );



	// Typography Options

	$typography_options = array(

		'sizes' => array( '6','12','14','16','20' ),

		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),

		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),

		'color' => false

	);



	// Pull all the categories into an array

	$options_categories = array();

	$options_categories_obj = get_categories();

	foreach ($options_categories_obj as $category) {

		$options_categories[$category->cat_ID] = $category->cat_name;

	}



	// Pull all tags into an array

	$options_tags = array();

	$options_tags_obj = get_tags();

	foreach ( $options_tags_obj as $tag ) {

		$options_tags[$tag->term_id] = $tag->name;

	}





	// Pull all the pages into an array

	$options_pages = array();

	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );

	$options_pages[''] = 'Select a page:';

	foreach ($options_pages_obj as $page) {

		$options_pages[$page->ID] = $page->post_title;

	}



	// If using image radio buttons, define a directory path

	$imagepath =  get_template_directory_uri() . '/images/';



	$options = array();



	$options[] = array(

		'name' => __( 'Basic Settings', 'theme-textdomain' ),

		'type' => 'heading'

	);



	$options[] = array(

		'name' => __( 'Logo', 'themeoption_item' ),

		'desc' => __( 'Upload logo for site', 'themeoption_item' ),

		'id' => 'logo',

		'type' => 'upload'

	);

	

	$options[] = array(

		'name' => __( 'Footer Logo', 'themeoption_item' ),

		'desc' => __( 'Upload logo for site', 'themeoption_item' ),

		'id' => 'footer_logo',

		'type' => 'upload'

	);

	

	$options[] = array(

		'name' => __( 'Favicon', 'themeoption_item' ),

		'desc' => __( 'Upload favicon for site', 'themeoption_item' ),

		'id' => 'favicon',

		'type' => 'upload'

	);

	

	$options[] = array(

		'name' => __( 'Facebook Link', 'theme-textdomain' ),

		'id' => 'facebook_link',

		'type' => 'text'

	);

		$options[] = array(

		'name' => __( 'Twitter Link', 'theme-textdomain' ),

		'id' => 'twitter_link',

		'type' => 'text'

	);

	$options[] = array(

		'name' => __( 'linkedin Link', 'theme-textdomain' ),

		'id' => 'linkedin_link',

		'type' => 'text'

	);

	

	// $options[] = array(

	// 	'name' => __( 'Youtube Link', 'theme-textdomain' ),

	// 	'id' => 'youtube_link',

	// 	'type' => 'text'

	// );



	// $options[] = array(

	// 	'name' => __( 'Linkedin Link', 'theme-textdomain' ),

	// 	'id' => 'linkedin_link',

	// 	'type' => 'text'

	// );

	

	 

	

	$options[] = array(

		'name' => __( 'Copyright Text', 'theme-textdomain' ),

		'id' => 'copyright_text',

		'type' => 'textarea'

	);



	$options[] = array(

		'name' => __( 'Contents', 'theme-textdomain' ),

		'type' => 'heading'

	);



	$options[] = array(

		'name' => __( 'Footer Address', 'theme-textdomain' ),

		'id' => 'header_address',

		'type' => 'textarea'

	);



	$options[] = array(

		'name' => __( 'Email Address', 'theme-textdomain' ),

		'id' => 'email_address',

		'type' => 'text'

	);



	$options[] = array(

		'name' => __( 'Contact No', 'theme-textdomain' ),

		'id' => 'contact_no',

		'type' => 'text'

	);

	$options[] = array(

		'name' => __( 'Whatsapp No.', 'theme-textdomain' ),

		'id' => 'whatsapp_no',

		'type' => 'text'

	);

	$options[] = array(

		'name' => __( 'Profile Image', 'themeoption_item' ),

		'desc' => __( 'Upload logo for site', 'themeoption_item' ),

		'id' => 'profile_image',

		'type' => 'upload'

	);


	// $options[] = array(

	// 	'name' => __( 'Our Service Heading', 'theme-textdomain' ),

	// 	'id' => 'service_heading',

	// 	'type' => 'text'

	// );

	// $options[] = array(

	// 	'name' => __( 'Our Service Content', 'theme-textdomain' ),

	// 	'id' => 'service_content',

	// 	'type' => 'textarea'

	// );



	$options[] = array(

		'name' => __( 'Footer About Content', 'theme-textdomain' ),

		'id' => 'about_content',

		'type' => 'textarea'

	);



	

	/**

	 * For $settings options see:

	 * http://codex.wordpress.org/Function_Reference/wp_editor

	 *

	 * 'media_buttons' are not supported as there is no post to attach items to

	 * 'textarea_name' is set by the 'id' you choose

	 */



	$wp_editor_settings = array(

		'wpautop' => true, // Default

		'textarea_rows' => 5,

		'tinymce' => array( 'plugins' => 'wordpress' )

	);



	$options[] = array(

		'name' => __( 'Welcome Content', 'theme-textdomain' ),

		'id' => 'welcome_content',

		'type' => 'editor',

		'settings' => $wp_editor_settings

	);





	return $options;

}