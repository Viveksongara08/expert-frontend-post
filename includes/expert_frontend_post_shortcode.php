<?php
class Expertfrontendpost
{

    function __construct()
    {

        add_shortcode('expert_frontend_add_posts_form', [$this, 'expert_frontend_add_posts_form_shortcode']);
        //add_shortcode( 'expert_frontend_edit_posts_form', [$this,'expert_frontend_edit_posts_form_shortcode'] );
        add_shortcode('expert_frontend_posts_listing', [$this, 'expert_frontend_posts_listing_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'expert_frontend_post_scripts_styles']);
        add_action('expert_post_form_nonce', [$this, 'expert_add_post_form_nonce']);
        add_action('show_custom_post_categories', [$this, 'Custom_post_categories']);
        add_action('show_custom_post_tags', [$this, 'Custom_post_tags']);
        add_action('show_custom_post_thumb_edit_page', [$this, 'Custom_post_thumb_edit_page']);
        add_action('expert_post_edit_form_nonce', [$this, 'expert_edit_post_form_nonce']);
        add_action('sucess_message', [$this, 'show_message']);
        
   
    }

    // ********* // Addpost Shortcode [expert_frontend_add_posts_form] // ******** //
    // ********* // Add nonce // ******** //
    function expert_add_post_form_nonce()
    {

        $nonce = wp_create_nonce("expert_add_post_nonce");
?>
        <input type="hidden" name="nonce" id="nonce" value="<?php echo $nonce; ?>" />
        <input type="hidden" name="action" id="action" value="expert_add_expert_posts" />

        <?php
    }

    function expert_edit_post_form_nonce()
    {
        $expert_post_id=$_REQUEST["edit"];
        $nonce = wp_create_nonce("expert_edit_post_nonce");
?>
        <input type="hidden" name="expert_post_id" id="expert_post_id" value="<?php echo $expert_post_id; ?>" />
        <input type="hidden" name="nonce" id="nonce" value="<?php echo $nonce; ?>" />
        <input type="hidden" name="action" id="action" value="expert_edit_expert_posts" />

        <?php
    }

    function show_message(){
        echo"<p id='sucess_box' > </p>";
    }


    function expert_frontend_add_posts_form_shortcode()
    {
        ob_start();
        global $post;

        include('templates/add_expert_post.php');
        return ob_get_clean();
    }

    /*
    *
    * Check post exist
    *
    */
    function postexists($id, $ptype)
    {
        global $wpdb;
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d  and post_type=%d", $id, $ptype), ARRAY_A);
        if (!empty($result)) {
            return true;
        }
    }

    /* 
    $edit // edit post id
    @ show custom categories
    */
    function Custom_post_categories($edit = "")
    {
        $category = get_the_terms($edit, 'expertcat');
        $categorys1[] = "";
        if (!empty($category)) {
            foreach ($category as $cat1) {
                $categorys1[] = $cat1->term_id;
            }
        }

        $arg = array('taxonomy' => 'expertcat', 'orderby' => 'id', 'show_count' => 0, 'pad_counts' => 0, 'hierarchical' => 1, 'title_li' => '', 'hide_empty' => 0);
        $all_categories = get_categories($arg);
        if (!empty($all_categories)) {
        ?>
            <select class="au-input au-input--full" multiple name="category[]" id="categoryselect">
                <?php foreach ($all_categories as $cats) {  ?>
                    <option <?php if (in_array($cats->term_id, $categorys1)) {
                                echo "selected";
                            } ?> value="<?php echo $cats->term_id; ?>"><?php echo $cats->name; ?></option>
                <?php  } ?>
            </select>

        <?php  }
    }

    /* 
    $edit // edit post id
    @ show custom tags
    */
    function Custom_post_tags($edit = "")
    {
        $string_tags = "";
        $tag_detail = get_the_terms($edit, 'experttags');
        if (!empty($tag_detail)) {


            foreach ($tag_detail as $tag) {
                $tags1[] = $tag->name;
            }
            $string_tags = implode(",", $tags1);
        }
        // print_r($tags1);exit;

        ?>
        <input value="<?php echo $string_tags; ?>" class="au-input au-input--full" type="text" id="expert_tags" name="expert_tags" placeholder="Tags">
    <?php

    }

    /* 
    $edit // edit post id
    @ show edit thumb
    */

    function Custom_post_thumb_edit_page($edit="")
    {
        $thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id ($edit), 'full');
           ?>
      <img src="<?= $thumbnail[0]; ?>" alt="" class="thum">
      <?php 

    }

    // ********* // Postslisting Shortcode [expert_frontend_posts_listing] // ******** //

    function expert_frontend_posts_listing_shortcode()
    {
        ob_start();
        global $post;

        if ($this->postexists($_REQUEST['edit'], 'expert_posts') == true) {
            include('templates/edit_expert_post.php');
        } else {
            include('templates/expert_post_listing.php');
        }




        return ob_get_clean();
    }




    function expert_frontend_post_scripts_styles()
    {

        //  Add css
        wp_enqueue_style('theme1', RNR_PATH . '/css/theme.css', false, '1.0.0', 'all');

        // Register the JS file with a unique handle, file location, and an array of dependencies
        wp_register_script("custom-js", RNR_PATH . '/js/custom.js', array('jquery'));


        // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
        wp_localize_script('custom-js', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        // enqueue jQuery library and the script you registered above
        wp_enqueue_script('jquery');
        wp_enqueue_script('custom-js');
    ?>

<?php
    }
}

$obj = new Expertfrontendpost();
