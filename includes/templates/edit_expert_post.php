<?php 
   $postID=$_REQUEST["edit"];
   $Datapost = get_post($postID);
   $title= $Datapost->post_title;
   $content= $Datapost->post_content;
   ?>
   
<div class="login-wrap">
  <div class="login-content">
    <div class="login-logo">
      <h3> <?php echo get_the_title(); ?> </h3>
    </div>
    <div class="login-form">
      <form action="" method="post" name="editexpost" id="editexpost" enctype="multipart/form-data">
        <div class="form-group">
          <label>Title</label>
          <input  value="<?php echo $title;  ?>" class="au-input au-input--full" type="text" id="expert_title" name="expert_title" placeholder="Titles">
        </div>
        <div class="form-group">
          <label>Categories</label>
        <?php  do_action('show_custom_post_categories',$postID); ?>
        </div>
        <div class="form-group">
          <label>Tags</label>
          <?php echo do_action('show_custom_post_tags',$postID); ?>
        </div>
        <div class="form-group">
         
          <label>Upload Image</label>
         
          <input class="au-input au-input--full" type="file" name="expert_upload_image" id="expert_upload_image">
          <?php do_action('show_custom_post_thumb_edit_page',$postID); ?>
        </div>
        <div class="form-group">
          <label>Content</label>
          <textarea class="au-input au-input--full" name="expert_content_post"><?php echo $content; ?></textarea>

        </div>
        <?php do_action('expert_post_edit_form_nonce'); ?>
        <button class="au-btn au-btn--block au-btn--green m-t-20" type="submit">Update</button>

      </form>
      <?php do_action('sucess_message'); ?>
    </div>
  </div>
</div>