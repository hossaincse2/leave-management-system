<?php
add_shortcode('leaveList', 'frontend_leave_shortcode');
/**
 * Shortcode to display a CMB2 form for a post ID.
 * @param  array  $atts Shortcode attributes
 * @return string       Form HTML markup
 */
function frontend_leave_shortcode($atts = array() , $content = null)
{
    $shortAtts = shortcode_atts([
        'limit' => 5,
    ], $atts);

    $leaveList = product_leave_Public::get_all_leave_for_shortCode($shortAtts['limit']);
    ?> 

<div class="card home-card">
    <h6 class="leave-title">leave List</h6>
    <div class="table-responsive">
        <table class="table table-hover">
                <thead>
                    <tr> 
                    <th scope="col">leave ID</th>
                    <th scope="col">leave Name</th>
                    <th scope="col">End User Name</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($leaveList as $key => $value) { ?>    
                    <tr> 
                        <td>#NS00<?php echo $value->id; ?></td>
                        <td><?php echo $value->leave_name; ?></td>
                        <td><?php echo $value->enduser_name; ?></td>
                        <td> <a href="<?php echo home_url(); ?>/leave_edit?leave-id=<?php echo $value->id; ?>">Edit</a> | <a class="leaveDelete" data-nonce="<?php echo wp_create_nonce( 'leaveDelete' ); ?>" data-id="<?php echo $value->id; ?>" href="#">Delete</a> </td>
                    </tr>
                <?php   } ?> 
        
            </tbody>
        </table>
    </div>
</div>
 
<?php

}