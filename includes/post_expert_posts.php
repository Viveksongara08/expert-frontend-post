<?php
/*************************************************/
/*** expert posts
/**************************************************/
add_action( 'init', 'icee_expert_posts' );  
function icee_expert_posts() {
	
	$labels = array(
		'name' 				=> _x('Expert posts ', 'post type general name'),
		'add_new' 			=> 'Add Expert posts ',
		'add_new_item' 		=> 'Add Expert posts ',
		'edit_item' 		=> __('Edit Expert posts '),
		'new_item' 			=> __('New Expert posts '),
		'all_items' 		=> __('All Expert posts '),
		'view_item' 		=> __('View Expert posts '),
		'search_items' 		=> __('Search Expert posts '),
		'not_found' 		=>  __('Empty'),
		'not_found_in_trash'=> __('Empty Expert posts '), 
		'parent_item_colon' => '',
		'menu_name' 		=> __('Expert posts ')
	);

	$args = array(
		'labels' 			=> $labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'exclude_from_search'=> true,
		'show_ui' 			=> true, 
		'show_in_menu' 		=> true, 
		'query_var' 		=> true,
		'rewrite'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true, 
		'hierarchical'		=> false,
		'menu_position' 	=> NULL,
		'show_in_rest'     => true,
		'supports' 			=> array( 'title', 'editor', 'thumbnail',),
        //'taxonomies'          => array( 'category' ),
		
		
	);
	
	register_post_type("expert_posts",$args);
	register_taxonomy("expertcat", array("expert_posts"), array("hierarchical" => true, "label" => "Categories", "singular_label" => "Categories", "rewrite" => true));
	register_taxonomy("experttags", array("expert_posts"), array("false" => true, "label" => "Tags", "singular_label" => "Tags", "rewrite" => true));
	
	//register_taxonomy("governmentindustry", array("governmentprojects"), array("hierarchical" => true, "label" => "Government Industry", "singular_label" => "Government Industry", "rewrite" => true));
	
	//register_post_type("counselingprojects",$args);
	
	//register_taxonomy("referencecicategory", array("referenceci"), array("hierarchical" => true, "label" => "Reference Cloud Infrastructure Category", "singular_label" => "Reference Cloud Infrastructure Category", "rewrite" => true));
	
	//register_taxonomy("freecourseuniversity", array("freecourses"), array("hierarchical" => true, "label" => "Free University", "singular_label" => "Free University", "rewrite" => true));
}


?>