<?php
if ( function_exists( 'acf_add_options_page' ) ) :

	$parent = acf_add_options_page(array(
		'page_title'    => 'Theme Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-settings',
		'capability'    => 'edit_posts',
		'show_in_graphql' => true,
		'redirect'      => false
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Theme Header Settings',
		'menu_title'    => 'Header',
		'parent_slug'   => $parent['menu_slug'],
		'show_in_graphql' => true,
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Theme Footer Settings',
		'menu_title'    => 'Footer',
		'parent_slug'   => $parent['menu_slug'],
		'show_in_graphql' => true,
	));

endif;

function twentytwentyotwo_styles() {
	wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css', array(), '5.3.0', false );
  wp_enqueue_style( 'child-style', get_stylesheet_uri(),
  array( 'twenty-twenty-two-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles');

function twentytwentytwo_admin_styles(){
	//first register sthe style sheet and then enqueue
	wp_register_style( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css', array(), '5.3.0', 'all' );
	wp_enqueue_style( 'bootstrap' );
}
add_action('admin_enqueue_scripts', 'twentytwentytwo_admin_styles');

function acf_init_block_types() {
  if( function_exists( 'register_block_type' ) ) {
    register_block_type(get_stylesheet_directory() . "/template-parts/blocks/ctaButton/block.json");
    register_block_type(get_stylesheet_directory() . "/template-parts/blocks/banner/block.json");
    register_block_type(get_stylesheet_directory() . "/template-parts/blocks/half-content-half-video/block.json");
    register_block_type(get_stylesheet_directory() . "/template-parts/blocks/blog-listing/block.json");
		register_block_type(get_stylesheet_directory() . "/template-parts/blocks/search/block.json");
		register_block_type(get_stylesheet_directory() . "/template-parts/blocks/book-details/block.json");
		register_block_type(get_stylesheet_directory() . "/template-parts/blocks/book-listing/block.json");
  }
}
add_action('acf/init', 'acf_init_block_types');

function mondiale_force_image_json_acf_graphql($attributes, $block_type){
	
	foreach($attributes["data"] as $key => $value ){
		if(str_starts_with($key, '_') && str_contains($value, 'field')){
			$field = get_field_object($value);
			

			if($field && isset($field['type']) && $field['type'] == 'image') {
				$original_field = trim($key, "_");
				$array_new["url"] = wp_get_attachment_image_url ( $attributes["data"][$original_field], 'full' );
				$array_new["alt"] = get_post_meta( $attributes["data"][$original_field], '_wp_attachment_image_alt', true);
				$attributes["data"][$original_field] = $array_new;
			}
			
			if($field && isset($field['type']) && $field['type'] == 'file') {
				$original_field = trim($key, "_");
				$array_new["url"] = wp_get_attachment_url ( $attributes["data"][$original_field]);
				$attributes["data"][$original_field] = $array_new;
			}

			if($field && isset($field['type']) && $field['type'] == 'relationship') {
				$original_field = trim($key, "_");

				$taxonomies=get_taxonomies();
				if($taxonomies && is_array($taxonomies)) $food_names =(array_values($taxonomies));

				if($attributes["data"][$original_field] && is_array($attributes["data"][$original_field])){
					foreach($attributes["data"][$original_field] as $key=>$innPosts){ 

						$get_posts = get_post( $innPosts );
						if(!$get_posts) continue;

						if($food_names && is_array($food_names)) $terms = wp_get_post_terms($get_posts->ID, $food_names);
						if($terms && is_array($terms)) $termName = wp_list_pluck($terms, 'name');

						$array_new["postData"][$key]["ID"] = base64_encode('post:' .$get_posts->ID);
						($terms && is_array($terms)) ? $array_new["postData"][$key]["cat_name"] = $termName[0] : $array_new["postData"][$key]["cat_name"] = "";
						$array_new["postData"][$key]["post_slug"] = $get_posts->post_name;
						$array_new["postData"][$key]["post_title"] = $get_posts->post_title;
						$array_new["postData"][$key]["post_content"] = $get_posts->post_content;
						$array_new["postData"][$key]["post_excerpt"] = $get_posts->post_excerpt;
						$array_new["postData"][$key]["post_thumnnail"] = get_the_post_thumbnail_url($get_posts->ID, 'thumbnail'); 
						$array_new["postData"][$key]["post_full"] = get_the_post_thumbnail_url($get_posts->ID, 'full'); 
					}
					$attributes["data"][$original_field] = $array_new;
				}
				
			}
			
		}
	}
	return $attributes;
}
add_filter("graphql_gutenberg_block_attributes", "mondiale_force_image_json_acf_graphql", 10, 2);

function wpnext_force_blacks_attributes_graphql($attributes, $data, $post_id) {
	if(isset($attributes['data'])){
		$attributesData = $attributes['data'];
		foreach ($attributesData as $key => $value) {
			// attributes that start with an underscore _ are set to the field keys
			if(substr($key, 0, 1) == '_' && function_exists('get_field_object')){
				$fieldObject = get_field_object($value);

				// handle acf file field
				if($fieldObject && $fieldObject['type'] == 'file'){
					$fileId = $attributes['data'][substr($key, 1)];
					// get media item
					$fileUrl = wp_get_attachment_url($fileId);

					if($fieldObject['return_format'] == 'url'){
						$attributes['data'][substr($key, 1)] = $fileUrl;
					}else if($fieldObject['return_format'] == 'array'){
						$attributes['data'][substr($key, 1)] = array(
							'id' => $fileId,
							'url' => $fileUrl,
						);
					}else if($fieldObject['return_format'] == 'id'){
						$attributes['data'][substr($key, 1)] = $fileId;
					}
				}
			}
		}
	}
	if($data['blockName'] == 'acf/book-details') {
		$book_id = get_the_ID();
		$attributes["data"]["author"] = get_field('author', $book_id);
		$attributes["data"]["genres"] = get_the_terms( $book_id, "genre" );
		$attributes["data"]["publishYear"] = get_field('publish_year', $book_id);
		$attributes["data"]["price"] = get_field('price', $book_id);
		$attributes["data"]["description"] = get_field('description', $book_id);
		$attributes["data"]["featuredImage"]["url"] = get_the_post_thumbnail_url($book_id, 'full');
		$attributes["data"]["featuredImage"]["alt"] = get_post_meta( get_post_thumbnail_id($book_id), '_wp_attachment_image_alt', true );
		$attributes["data"]['title'] = get_the_title();
	}
	return $attributes;
}
add_filter("wp_graphql_blocks_process_attributes", "wpnext_force_blacks_attributes_graphql", 10, 3);