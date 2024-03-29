<?php
 /* Template Name: Product leave Page */
 if ( !is_user_logged_in() ) {
  header('Location: ' . wp_login_url());
} 
 wp_head();

 get_header();
 global $current_user;
   get_currentuserinfo();
  //  print_r($current_user);
 $userId =  $current_user->ID;
  $leaveId =  $_GET['leave-id'];
  $details =  product_leave_Public::get_details_leave($leaveId); 
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
         <span>Edit leave</span> 
         <ul class="list-inline listMenu">
            <li class="list-inline-item"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/leave_list">leave List</a></li>
           </ul>
        </div>
        <div class="card-body">
        <form action="">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="email">leave Name</label>
                  <input type="hidden" class="form-control" name="leaveId" id="leaveId" value="<?php echo isset( $details[0]->id ) ?  $details[0]->id : ''; ?>">
                  <input type="text" class="form-control" value="<?php echo isset( $details[0]->leave_name ) ?  $details[0]->leave_name : ''; ?>" name="leaveName" id="leaveName">
                 </div>
                 <div class="form-group">
                    <label for="pwd">leave Description</label>
                    <textarea name="description" id="description" cols="30" rows="7"><?php echo  isset( $details[0]->leave_description ) ?  $details[0]->leave_description : ''; ?></textarea>
                  </div> 
                 
               </div>
               <div class="col-md-6">
               <div class="form-group">
                  <label for="pwd">End User</label>
                  <input type="text" class="form-control" value="<?php echo  isset( $details[0]->enduser_name ) ?  $details[0]->enduser_name : ''; ?>" name="endUserName" id="endUserName">
                 </div> 
                 <div class="form-group">
                    <label for="pwd">End User Contact Person</label>
                    <input type="text" class="form-control" name="endUserContactPerson" id="endUserContactPerson" value="<?php echo isset(  $details[0]->enduser_contact_person ) ?   $details[0]->enduser_contact_person : ''; ?>">
                  </div> 
                 <div class="form-group">
                    <label for="pwd">End User Contact Number</label>
                    <input type="text" class="form-control" name="endUserContact" id="endUserContact" value="<?php echo isset(  $details[0]->enduser_contact ) ?   $details[0]->enduser_contact : ''; ?>">
                  </div> 
                 
                <div class="form-group">
                  <label for="email">End User Email</label>
                  <input type="email" class="form-control" value="<?php echo isset(  $details[0]->enduser_email ) ?   $details[0]->enduser_email : ''; ?>" name="endUserEmail" id="endUserEmail">
                 </div> 
                 <div class="form-group">
                    <label for="pwd">End User Address</label>
                    <textarea name="endUserAddress" value="<?php echo  isset( $details[0]->enduser_address ) ?  $details[0]->enduser_address  : ''; ?>" id="endUserAddress" cols="30" rows="2"><?php echo  isset( $details[0]->enduser_address ) ?  $details[0]->enduser_address : ''; ?></textarea>
                  </div> 
               </div>
          </div> 
          <div class="col-md-12  text-right p0">
             <button type="submit" id="leaveEdit" class="btn btn-primary">Save</button>
          </div>
        </form>
        </div>
     </div>
    <div class="leave-cart">
    <div class="card">
    <div class="card-header">
          <span class="titleList"><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/list.svg'; ?>" alt=""> List  Products</span>  
          <ul class="list-inline listMenu">
            <li class="list-inline-item"><a id="btn_delete" class="social-icon text-xs-center" href="#"> <img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/delete.svg'; ?>" alt=""> Delete</a></li>
            <!-- <li class="list-inline-item"><a id="btn_export" class="social-icon text-xs-center" href="<?php echo home_url(); ?>/leave?leave-id=<?php echo $leaveId; ?>&download_csv=1"><img style="width: 18px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/export.svg'; ?>" alt=""> Export</a></li> -->
            <li class="list-inline-item dropdown"><a   class="social-icon text-xs-center  dropdown-toggle" data-toggle="dropdown" href="#""><img style="width: 18px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/export.svg'; ?>" alt=""> Export</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" data-id = "<?php echo isset($_GET['leave-id']) ? $_GET['leave-id'] : '';  ?>" id="btn_export_pdf"  href="#">Export as pdf</a>
                <a class="dropdown-item" data-id = "<?php echo isset($_GET['leave-id']) ? $_GET['leave-id'] : '';  ?>" id="btn_export"  href="#">Export as csv</a>
             </div>
          </li>
            <li class="list-inline-item"><a id="leave_clone" data-id = "<?php echo isset($_GET['leave-id']) ? $_GET['leave-id'] : '';  ?>" class="social-icon text-xs-center" href="#"><img style="width: 15px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/clone.svg'; ?>" alt=""> Clone</a></li>
            <li class="list-inline-item"><a id="btn_email" class="social-icon text-xs-center"  href="#"><img style="width: 15px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/email.svg'; ?>" alt=""> Email</a></li>
            <li class="list-inline-item"><a id="btn_convert" class="social-icon text-xs-center"   href="#"><img style="width: 20px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/convert.svg'; ?>" alt=""> Convert To Cart</a></li>
          </ul>
        </div>
        <div class="card-body">
           
           <div class="shopping-cart">
           <?php
           $leaveId = isset($_GET['leave-id']) ? $_GET['leave-id'] : '';
           $allProducts = product_leave_Public::allGetProducts($leaveId);  
        //  if( !empty($allProducts)){
        ?>
           <div class="column-labels">
                <label class="product-removal"><input id="checkAll" type="checkbox"></label>
                <label class="product-code">Product Code</label>
                <label class="product-details text-left">Product Description</label>
                <label class="product-price text-right">Unit Price</label>
                <label class="product-quantity text-right">Quantity</label>
                <label class="product-line-price text-right">Total</label>
              </div> 
           <!-- <?php // } ?>   -->
           <div class="productListBody">  
 <?php 
  if( !empty($allProducts)){ 
   $subtotal = 0;
   $subtotalTax = 0;
   foreach($allProducts as $productItem){
     $product = wc_get_product( $productItem['product_id'] );
     $totalQty = product_leave_Public::getTotalQty($productItem['product_id'],$leaveId) ;
     $qty = $totalQty[0]['totalQty'];
     $productQty =  $qty != ''  ?  $qty  : 1;
     
     $with_tax = $product->get_price_including_tax();
     $without_tax = $product->get_price_excluding_tax();
     $tax_amount = $with_tax - $without_tax;
     if($without_tax != 0){
        $without_taxTotalPrice = $without_tax * $productQty; 
        $subtotal = $subtotal + $without_taxTotalPrice; 
        $totalTax = $productQty * $tax_amount;
        $subtotalTax = $subtotalTax + $totalTax;
     }else{
        $productTotalPrice = $product->get_price() * $productQty; 
        $subtotal = $subtotal + $productTotalPrice; 
        $totalTax = 0;
     }
    
      
   ?>
   
    <div id="remove<?php echo $productItem['id']; ?>" class="product"> 
            
								<div  class="product-removal"> 
									<div class="checkBox"> 
											 <input name="products_id[]" id="checkboxes-0" value="<?php echo $productItem['id']; ?>" type="checkbox" data-id="<?php echo $productItem['id']; ?>" data-leaveId="<?php echo $leaveId; ?>" data-productId="<?php echo $productItem['product_id']; ?>" data-nonce="<?php echo wp_create_nonce( 'productDelete' ); ?>" >
									</div>
										<!-- <a data-id="<?php echo $productItem['id']; ?>" data-leaveId="<?php echo $leaveId; ?>" data-productId="<?php echo $productItem['product_id']; ?>" data-nonce="<?php echo wp_create_nonce( 'productDelete' ); ?>"  class="remove-product">
											 <img style="width:20px" src="<?php echo get_template_directory_uri() . '/img/delete.svg' ?>" alt="">
										</a> -->
									</div>
                  <div class="product-code text-left"><?php echo  $product->get_sku() != '' ? $product->get_sku()  : 'Empty'; ?></div>
                  <div class="product-details">
										<div class="product-title"><?php echo $product->get_name(); ?></div>
										<p class="product-description"> It has a lightweight, breathable mesh upper with forefoot cables for a locked-down fit.</p>
									</div>
									<div class="product-price text-right"><?php echo $without_tax !=0 ? number_format((float)$without_tax,2) : number_format($product->get_price(), 2); ?></div>
									<div class="product-quantity text-right">
										<input type="text" data-id="<?php echo $productItem['id']; ?>" value="<?php echo $productQty; ?>" min="1">
                	</div> 
                    <input type="hidden"  class="tax-amount" class="tax-amount" value="<?php echo (round($tax_amount,2)); ?>">
                    <input type="hidden" class="sub-tax-amount" value="<?php echo (round($totalTax,2)); ?>">
 									<div class="product-line-price"><?php echo $without_tax !=0 ? number_format((float)$without_taxTotalPrice,2) : number_format($productTotalPrice, 2); ?></div>
						     </div>
             
         
<?php }		 ?>
          <div class="totals">
             <div class="totals-item">
               <label>Subtotal</label>
               <div class="totals-value" id="cart-subtotal"> <?php echo  number_format($subtotal, 2); ?></div>
             </div>
             <div class="totals-item">
                  <label>leaved Tax</label>
                  <div class="totals-value" id="cart-tax"> <?php echo number_format($subtotalTax,2); ?></div>
                </div>
             <!-- <div class="totals-item">
               <label>Shipping</label>
               <div class="totals-value" id="cart-shipping">15.00</div>
             </div> -->
             <div class="totals-item totals-item-total">
               <label>Grand Total</label>
               <div class="totals-value" id="cart-total"> <?php echo number_format($subtotalTax + $subtotal, 2); ?></div>
             </div>
           </div>
           </div>     
               <!-- <button class="btn btn-primary float-right">Export</button> -->
               <?php }else{
            // echo 'No Products';
     } ?>
           </div> 
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