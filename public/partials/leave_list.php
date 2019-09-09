<?php
 /* Template Name: Product leave Page */
 if ( !is_user_logged_in() ) {
  header('Location: ' . wp_login_url());
} 
 wp_head();

 get_header();
 global $current_user;
   get_currentuserinfo();
  $userId =  $current_user->ID;
  // $leave = new product_leave_Public();
  $leaveList = product_leave_Public::get_all_leave();
?>

<div class="container" style="margin-top:100px">
  <div class="row">
  <div class="col-md-3">
    <div class="aside">
         <div class="devicelist">
              <!-- Sidebar -->
        <div class="bg-light" id="sidebar-wrapper">
        <div class="sidebar-heading">Device List </div>
        <div class="list-group list-group-flush">
            <?php do_action ( 'device_list' ); ?> 
        </div>
        
        </div>
        </div>

        <div  style="margin:25px 0px" class="bg-light" id="sidebar-wrapper">
        <div class="sidebar-heading">Sensor List </div>
        <?php do_action ( 'sensore_list' ); ?> 
     
        <!-- /#sidebar-wrapper -->
            <?php //echo do_shortcode(' [recent_products per_page="4" columns="1" orderby=”date” order="ASC"]'); ?>
        </div>
        <!-- <h5>Sensore List</h5>
        <div class="devicelist">
            <?php //echo do_shortcode(' [recent_products per_page="4" columns="1" orderby=”date” order="ASC"]'); ?>
        </div> -->
    </div>
  </div>
  <div class="col-md-9 leave_section"> 
    
    <!-- <div class="cart-pakage">
        <?php //echo do_shortcode('[woocommerce_cart] '); ?>
    </div> -->
    <div class="card">
        <div class="card-header">
         <span>leave List</span> 
         <ul class="list-inline listMenu">
            <li class="list-inline-item"><a class="social-icon text-xs-center" href="<?php echo home_url(); ?>/leave">Create leave</a></li>
           </ul>
        </div>
        <div class="card-body">
        <div class="table-responsive">          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>leave Name</th>
                <th>End User Name</th>
                <!-- <th>End User Email</th>
                <th>End User Contact</th> -->
                <!-- <th>Created Date</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($leaveList as $key => $value) { ?>           
              <tr>
                <td><?php echo $value->id; ?></td>
                <td><?php echo $value->leave_name; ?></td>
                <td><?php echo $value->enduser_name; ?></td>
                <!-- <td><?php echo $value->enduser_email; ?></td>
                <td><?php echo  $value->enduser_contact; ?></td> -->
                <!-- <td><?php echo  $value->cdate; ?></td>  -->
                <td>
                  <a href="<?php echo home_url(); ?>/leave?leave-id=<?php echo $value->id; ?>">Edit</a> | <a class="leaveDelete" data-nonce="<?php echo wp_create_nonce( 'leaveDelete' ); ?>" data-id="<?php echo $value->id; ?>" href="#">Delete</a>
                </td>
              </tr>
              <?php   } ?>
            </tbody>
          </table>
          </div>
        </div>
     </div>
    



    <div class="bundle-pakage">
         <?php echo do_shortcode(' [products limit="4" columns="4" category="bundle-product" cat_operator="AND"]
'); ?>
    </div>
  </div>
  </div>
</div>
<?php
get_footer();