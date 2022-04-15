<?php
//define the actions for the two hooks created, first for logged in users and the next for logged out users
add_action("wp_ajax_expert_add_expert_posts", "expert_add_expert_posts");
add_action("wp_ajax_nopriv_expert_add_expert_posts", "expert_add_expert_posts");

// define the function for login
function expert_add_expert_posts()
{
	if (!wp_verify_nonce($_REQUEST['nonce'], "expert_add_post_nonce")) {
		exit("Somthing was wrong.");
	}
	// echo "<pre>"; print_r($_POST);exit;
	$expert_title = sanitize_text_field(trim($_POST['expert_title']));
	$category = $_POST['category']; //sanitize_text_field(trim());
	$expert_tags = sanitize_text_field(trim($_POST['expert_tags']));
	$expert_content_post = sanitize_text_field(trim($_POST['expert_content_post']));

	$expert_tags = explode(",", $expert_tags);

	$tax = array(
		"expertcat" => $category,
		"experttags" => $expert_tags,
	);

	if (!empty($_FILES["expert_upload_image"]['name'][0])) {
		$attachid = file_uploads($_FILES["expert_upload_image"]);
	}

	// print_r($category);exit;
	$post_arguments = array(
		'post_author' => get_current_user_id(), // Author id
		'post_title' => $expert_title, // Post title
		'post_content' => $expert_content_post, // Post content
		'post_status'   => 'pending', // Now it's public
		'post_type'     => 'expert_posts', // Post type
		//'post_category'=>$category, // Default tag
		//'tags_input' => $expert_tags // Default category 
		'tax_input' => $tax, // Custom category and Tags

	);
	$insert = wp_insert_post($post_arguments, $wp_error = false);

	if ($insert && !empty($attachid)) {
		add_post_meta($insert, '_thumbnail_id', $attachid, true); //adding featured image to post
	}

	echo json_encode(array('postadd' => true, 'message' => __('Your post submit sucessfully. After admin review your post admin approve.')));

	die();
}

// edit post



//define the actions for the two hooks created, first for logged in users and the next for logged out users
add_action("wp_ajax_expert_edit_expert_posts", "expert_edit_expert_posts");
add_action("wp_ajax_nopriv_expert_edit_expert_posts", "expert_edit_expert_posts");

// define the function for login
function expert_edit_expert_posts()
{
	if (!wp_verify_nonce($_REQUEST['nonce'], "expert_edit_post_nonce")) {
		exit("Somthing was wrong.");
	}
	// echo "<pre>"; print_r($_POST);exit;
	$expert_title = sanitize_text_field(trim($_POST['expert_title']));
	$category = $_POST['category']; //sanitize_text_field(trim());
	$expert_tags = sanitize_text_field(trim($_POST['expert_tags']));
	$expert_content_post = sanitize_text_field(trim($_POST['expert_content_post']));
	$expert_post_id = $_REQUEST["expert_post_id"];

	$expert_tags = explode(",", $expert_tags);

	$tax = array(
		"expertcat" => $category,
		"experttags" => $expert_tags,
	);

	if (!empty($_FILES["expert_upload_image"]['name'][0])) {
		$attachid = file_uploads($_FILES["expert_upload_image"]);
	}

	// print_r($category);exit;
	$post_arguments = array(
		'ID' => $expert_post_id, // post id
		'post_title' => $expert_title, // Post title
		'post_content' => $expert_content_post, // Post content
		'post_type'     => 'expert_posts', // Post type
		//'post_category'=>$category, // Default tag
		//'tags_input' => $expert_tags // Default category 
		'tax_input' => $tax, // Custom category and Tags

	);

	wp_update_post($post_arguments, $wp_error = false);

	if ($expert_post_id && !empty($attachid)) {

		update_post_meta($expert_post_id, '_thumbnail_id', $attachid); //adding featured image to post

	}

	echo json_encode(array('postedit' => true, 'message' => __('Your post update sucessfully.')));

	die();
}

add_action("wp_ajax_expert_add_delete_posts", "expert_add_delete_posts");
add_action("wp_ajax_nopriv_expert_add_delete_posts", "expert_add_delete_posts");


function expert_add_delete_posts()
{

	$nonce = sanitize_text_field(trim($_POST['nonce']));
	$did = sanitize_text_field(trim($_POST['did']));
	if (!wp_verify_nonce($nonce, "expert_delete_post_nonce" . $did)) {
		exit("Somthing was wrong.");
	}
	wp_trash_post($did);
	echo json_encode(array('postdelete' => true, 'message' => __('Post delete sucessfully.')));

	die();
}

function file_uploads($name)
{

	if (!empty($name['name'][0])) {


		for ($j = 0; $j < count($name['name']); $j++) {



			if ($name['name'] != '') { //if user has uploaded the files
				$image_name = $name['name'];
				$ext_array = explode('.', $image_name);
				$ext = end($ext_array);

				if (!($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'JPEG' || $ext == 'PNG' || $ext == 'JPG')) {
					echo __('Invalid File Type', 'expert-frontend-post');
					$error_flag = 1;
					$image_error_flag = 1;
					//$error->image =
					die();
				}
			}

			if (!function_exists('wp_handle_upload'))
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			$uploadedfile = $name;
			$upload_overrides = array('test_form' => false);

			$file = array(
				'name'     => $uploadedfile['name'],
				'type'     => $uploadedfile['type'],
				'tmp_name' => $uploadedfile['tmp_name'],
				'error'    => $uploadedfile['error'],
				'size'     => $uploadedfile['size']
			);


			$movefile = wp_handle_upload($file, $upload_overrides);

			// 	echo "<pre>";
			// print_r($movefile); exit;

			if (isset($movefile['error'])) {
				$error_flag = 1;
				echo $error->image = $movefile['error'];

				exit;
			} else {
				if (!function_exists('wp_crop_image'))
					require_once(ABSPATH . 'wp-admin/includes/image.php');
				//include( ABSPATH . 'wp-admin/includes/image.php' );
				$wp_filetype = $movefile['type'];
				$filename = $movefile['file'];
				$wp_upload_dir = wp_upload_dir();
				$attachment = array(
					'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
					'post_mime_type' => $wp_filetype,
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment($attachment, $filename);
				//var_dump($attach_id);die();
				//echo"<pre>";
				$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
				wp_update_attachment_metadata($attach_id, $attach_data);
			}
			//$image_data[] =$attach_id;


		}

		return $attach_id;
	}
}



if ( ! function_exists( 'post_pagination' ) ) :
	function post_pagination($arr) {
	  
	  $pager = 999999999; // need an unlikely integer
  
		 echo paginate_links( array(
			  'base' => str_replace( $pager, '%#%', esc_url( get_pagenum_link( $pager ) ) ),
			  'format' => '?paged=%#%',
			  'current' => max( 1, get_query_var('paged') ),
			  'total' => $arr->max_num_pages
		 ) );
	}
 endif;

