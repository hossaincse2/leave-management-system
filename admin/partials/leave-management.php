<?php
 global $current_user;
get_currentuserinfo();
  $userId =  $current_user->ID;
  // $leave = new product_leave_Public();
  $leaveList = Leave_Management_Admin::get_all_leave();
?>

<div class="container" style="margin-top:30px">
  <div class="row">
  <h1>leave List</h1> 
  <div class="col-md-12 leave_section"> 
    
    <!-- <div class="cart-pakage">
        <?php //echo do_shortcode('[woocommerce_cart] '); ?>
    </div> -->
    <div class="card">
        <div class="card-header"> 
         <ul class="list-inline listMenu">
            <!-- <li class="list-inline-item"><a class="social-icon text-xs-center" href="<?php echo home_url(); ?>/leave">Create leave</a></li> -->
           </ul>
        </div>
        <div class="card-body">
        <div class="table-responsive">  



        <table id="leave" class="display" style="width:100%">
        <thead>
             <tr>
                <th>#</th>
                <th>leave Name</th>
                <th>End User Name</th>
                <th>End User Email</th>
                <th>End User Contact</th>
                <th>End User Address</th>
                <th>Created Date</th>
                <th>Action</th>
              </tr>
        </thead>
        <tbody>
        <?php foreach ($leaveList as $key => $value) { ?>           
              <tr>
                <td><?php echo $value->id; ?></td>
                <td><?php echo $value->leave_name; ?></td>
                <td><?php echo $value->enduser_name; ?></td>
                <td><?php echo $value->enduser_email; ?></td>
                <td><?php echo  $value->enduser_contact; ?></td>
                <td><?php echo  $value->enduser_address; ?></td> 
                <td><?php echo  $value->cdate; ?></td> 
                <td>
                  <a target=_blank href="<?php echo home_url(); ?>/leave_edit?leave-id=<?php echo $value->id; ?>">Edit</a> | <a class="leaveDelete" data-nonce="<?php echo wp_create_nonce( 'leaveDelete' ); ?>" data-id="<?php echo $value->id; ?>" href="#">Delete</a>
                </td>
              </tr>
              <?php   } ?>
        </tbody>
        <tfoot>
              <tr>
                <th>#</th>
                <th>leave Name</th>
                <th>End User Name</th>
                <th>End User Email</th>
                <th>End User Contact</th>
                <th>End User Address</th>
                <th>Created Date</th>
                <th>Action</th>
             </tr>
        </tfoot>
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