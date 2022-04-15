<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo _('S.No') ?></th>
            <th><?php echo _('Title') ?></th>
            <th><?php echo _('Status') ?></th>
            <th><?php echo _('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args1 = array(
            'post_type' => 'expert_posts', 'posts_per_page' =>9, 'orderby' => 'date',
            'order' => 'desc', 'author' => $user_id, 'post_status' => array('publish', 'pending', 'draft'), 'paged' => $paged, 'nopaging' => false
        );

        $testimonialQuery = new WP_Query($args1);
        if ($testimonialQuery->have_posts()) {
            $i = 1;
            while ($testimonialQuery->have_posts()) : $testimonialQuery->the_post();
                $thumbnail1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                setup_postdata($post);
        ?>
                <tr>
                    <td>
                        <?php echo $i; ?>
                    </td>
                    <td>
                        <h4><?php echo $post->post_title; ?></h4>                        
                    </td>
                    <td>
                    <?php echo $post->post_status; ?>
                    </td>
                    <td>
                        <a href="?edit=<?php echo $post->ID; ?>" class="btn btn-primary btn-sm btn-block " data-toggle="tooltip" data-placement="top" title="Edit">
                             Edit
                        </a>
                        <a  href="javascript:;" class="btn btn-danger btn-sm btn-block mt-2 expert-front-post-id" data-did="<?php echo $post->ID; ?>" data-nonce=<?php echo wp_create_nonce("expert_delete_post_nonce".$post->ID); ?> data-toggle="tooltip" data-placement="top" title="Delete">
                                 Delete
                         </a>
                    </td>
                </tr>
            <?php $i++;
            endwhile;  ?>
        <?php } else { ?>
            <tr class="tr-shadow">
                <td colspan="3" class="blog_title">NOT FOUND !</td>
            </tr>

        <?php } ?>
        <?php wp_reset_query();  ?>
        <tr class="tr-shadow">
            <td>
        <?php post_pagination($testimonialQuery); ?>
        </td>
        </tr>
    </tbody>
</table>