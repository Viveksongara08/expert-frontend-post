   <div class="login-wrap">
       <div class="login-content">
           <div class="login-logo">
               <h3> <?php echo get_the_title(); ?> </h3>
           </div>
           <div class="login-form">
               <form action="" method="post" name="addexpertpost" id="addexpertpost" enctype="multipart/form-data">
                   <div class="form-group">
                       <label>Title</label>
                       <input class="au-input au-input--full" type="text" id="expert_title" name="expert_title" placeholder="Titles">
                   </div>
                   <div class="form-group">
                       <label>Categories</label>
                       <?php
                        $arg = array('taxonomy' => 'expertcat', 'orderby' => 'id', 'show_count' => 0, 'pad_counts' => 0, 'hierarchical' => 1, 'title_li' => '', 'hide_empty' => 0);
                        $all_categories = get_categories($arg);
                        if (!empty($all_categories)) {
                        ?>
                           <select class="au-input au-input--full" multiple name="category[]" id="categoryselect">
                               <?php foreach ($all_categories as $cats) { ?>
                                   <option value="<?php echo $cats->term_id; ?>"><?php echo $cats->name; ?></option>
                               <?php  } ?>
                           </select>
                       <?php  } ?>

                   </div>
                   <div class="form-group">
                       <label>Tags</label>
                       <input class="au-input au-input--full" type="text" id="expert_tags" name="expert_tags" placeholder="Tags">
                   </div>
                   <div class="form-group">
                       <label>Upload Image</label>
                       <input class="au-input au-input--full" type="file" name="expert_upload_image" id="expert_upload_image">
                   </div>
                   <div class="form-group">
                       <label>Content</label>
                       <textarea class="au-input au-input--full" name="expert_content_post">
									</textarea>

                   </div>
                   <?php do_action('expert_post_form_nonce'); ?>
                   <button class="au-btn au-btn--block au-btn--green m-t-20" type="submit">Submit</button>

               </form>
            <?php do_action('sucess_message'); ?>
           </div>
       </div>
   </div>