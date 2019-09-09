<?php
 use Dompdf\Dompdf;

add_action( 'wp_ajax_leave_insert', 'leave_insert' );
add_action( 'wp_ajax_nopriv_leave_insert', 'leave_insert' );

function leave_insert() {

	global $wpdb;
		$tablename = $wpdb->prefix . "leave";

 		// if (isset($_POST['jobmeta_submit'])){
		$userId     = $_POST['userId']; //string value use: %s
		$leaveName    = $_POST['leaveName']; //string value use: %s
		$description    = $_POST['description']; //string value use: %s
		$endUserName    = $_POST['endUserName']; //numeric value use: %s
		$endUserEmail    = $_POST['endUserEmail']; //numeric value use:  %s
		$endUserContact    = $_POST['endUserContact']; //numeric value use: %s
		$endUserContactPerson    = $_POST['endUserContactPerson']; //numeric value use: %s
		$endUserAddress    = $_POST['endUserAddress']; //numeric value use:  %s
		
		// $exists = email_exists( $endUserEmail );

		// if ( $exists ) {
		// 	 echo "Email Exists";
		// } else {
		// 	echo "Email Doesn't Exists";
		// }

		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`leave_name`,`leave_description`,`enduser_name`, `enduser_email`, `enduser_contact_person`, `enduser_contact`, `enduser_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $leaveName, $description, $endUserName, $endUserContactPerson,$endUserContact, $endUserEmail, $endUserAddress);

		$wpdb->query($sql);
		// }

		echo $lastid = $wpdb->insert_id;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_leave_clone', 'leave_clone' );
add_action( 'wp_ajax_nopriv_leave_clone', 'leave_clone' );

function leave_clone() {

	global $wpdb;
		$tablename = $wpdb->prefix . "leave";
		$leaveId     = $_POST['id']; //string value use: %s
		// $products = 	getProductsByID($id);
		$leaveData = get_leave_by_id($leaveId);

	 
 		// if (isset($_POST['jobmeta_submit'])){
		$userId     = $leaveData['user_id']; //string value use: %s
		$leaveName    = $leaveData['leave_name'].' copy'; //string value use: %s
		$description    = $leaveData['leave_description']; //string value use: %s
		$endUserName    = $leaveData['enduser_name']; //numeric value use: %s
		$endUserEmail    = $leaveData['enduser_email']; //numeric value use:  %s
		$endUserContact    = $leaveData['enduser_contact_person']; //numeric value use: %s
		$endUserContactPerson    = $leaveData['enduser_contact']; //numeric value use: %s
		$endUserAddress    = $leaveData['enduser_address']; //numeric value use:  %s
		
		// $exists = email_exists( $endUserEmail );

		// if ( $exists ) {
		// 	 echo "Email Exists";
		// } else {
		// 	echo "Email Doesn't Exists";
		// }

		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`leave_name`,`leave_description`,`enduser_name`, `enduser_email`, `enduser_contact_person`, `enduser_contact`, `enduser_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $leaveName, $description, $endUserName, $endUserContactPerson,$endUserContact, $endUserEmail, $endUserAddress);

		$wpdb->query($sql); 
	
		$lastid = $wpdb->insert_id; 

	 if($lastid ){ 
		$allProducts = allGetProducts($leaveId); 
		foreach($allProducts as $allProduct){
			$tablename2 = $wpdb->prefix . "leave_products";
			$product_id = $allProduct ['product_id'];
			$product_name = $allProduct ['product_name'];
			$qty = $allProduct ['qty'];
			$price = $allProduct ['price'];
			$total_price = $allProduct ['total_price'];

			$sql = $wpdb->prepare("INSERT INTO `$tablename2` (`leave_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $lastid, $product_id, $product_name,$qty, $price, $total_price);

		$wpdb->query($sql);
		}
		echo $lastid;
	}
		// }

	
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}


function get_leave_by_id($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_row($sql,ARRAY_A);
	return $values;
}


add_action( 'wp_ajax_leave_edit', 'leave_edit' );
add_action( 'wp_ajax_nopriv_leave_edit', 'leave_edit' );

function leave_edit() {

	    global $wpdb;
	   $tablename = $wpdb->prefix . "leave";

 		// if (isset($_POST['jobmeta_submit'])){
		$leaveId     = $_POST['leaveId']; //string value use: %s
		$leaveName    = $_POST['leaveName']; //string value use: %s
		$description    = $_POST['description']; //string value use: %s
		$endUserName    = $_POST['endUserName']; //numeric value use: %s
		$endUserEmail    = $_POST['endUserEmail']; //numeric value use:  %s
		$endUserContact    = $_POST['endUserContact']; //numeric value use: %s
		$endUserContactPerson    = $_POST['endUserContactPerson']; //numeric value use: %s
		$endUserAddress    = $_POST['endUserAddress']; //numeric value use:  %s 

		// echo $sql = "UPDATE `$tablename`
		// SET `leave_name` = '$leaveName',
		// 	`enduser_name` = '$endUserName',
		// 	`enduser_email` = '$endUserEmail',
		// 	`enduser_contact` = '$endUserContact',
		// 	`enduser_address` = '$endUserAddress',
		// WHERE  `id` =  $leaveId" ;

		$sql =  $wpdb->prepare( "UPDATE `$tablename`
								   SET `leave_name` = '$leaveName',
								       `leave_description` = '$description',
								       `enduser_name` = '$endUserName',
								       `enduser_email` = '$endUserEmail',
								       `enduser_contact_person` = '$endUserContactPerson',
								       `enduser_contact` = '$endUserContact',
								       `enduser_address` = '$endUserAddress'
								   WHERE  `id` = %d", $leaveId );

		$wpdb->query($sql);
		// }

		  echo $leaveId;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_leave_product_updateByQty', 'leave_product_updateByQty' );
add_action( 'wp_ajax_nopriv_leave_product_updateByQty', 'leave_product_updateByQty' );

function leave_product_updateByQty() {

	    global $wpdb;
	   $tablename = $wpdb->prefix . "leave_products";

 		// if (isset($_POST['jobmeta_submit'])){
		$id     = $_POST['id']; //string value use: %s
		$qty    = $_POST['quantity']; //string value use: %s
		$total_price    = $_POST['totalPrice']; //string value use: %s
    
		$sql =  $wpdb->prepare( "UPDATE `$tablename`
								   SET `qty` = '$qty',
								       `total_price` = '$total_price'
								   WHERE  `id` = %d", $id );

		$wpdb->query($sql);
		// }

		  echo $id;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_leave_delete', 'leave_delete' );
add_action( 'wp_ajax_nopriv_leave_delete', 'leave_delete' );

function leave_delete() {

	    global $wpdb;

		$tablename = $wpdb->prefix . "leave"; 
		$leaveId  = $_POST['leaveId'];  
		$nonce  = $_POST['nonce'];  
		 
		 if(wp_verify_nonce( $nonce, 'leaveDelete')){
			$sql = "DELETE FROM `$tablename` WHERE id = '$leaveId'";
		 }
	   
		$wpdb->query($sql);
  
		echo $leaveId;
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_leave_product_delete', 'leave_product_delete' );
add_action( 'wp_ajax_nopriv_leave_product_delete', 'leave_product_delete' );

function leave_product_delete() {

	    global $wpdb;

		$tablename = $wpdb->prefix . "leave_products"; 
		$id  = $_POST['id'];  
		$productId  = $_POST['productId'];  
		$leaveId  = $_POST['leaveId'];  
		$nonce  = $_POST['nonce'];  
		 
		 if(wp_verify_nonce( $nonce, 'productDelete')){
		  echo	$sql = "DELETE FROM `$tablename` WHERE leave_id = '$leaveId' and product_id = '$productId'";
		 }
	   
		$wpdb->query($sql);
  
		echo $productId;
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_leave_product_multiple_delete', 'leave_product_multiple_delete' );
add_action( 'wp_ajax_nopriv_leave_product_multiple_delete', 'leave_product_multiple_delete' );

function leave_product_multiple_delete() {

			global $wpdb;
		 

		$tablename = $wpdb->prefix . "leave_products"; 
		$id  = $_POST['id'];  
		$nonce  = $_POST['nonce'];  
		foreach($_POST["id"] as $id){
 						$sql = "DELETE FROM `$tablename` WHERE id = '$id'";
						$wpdb->query($sql);
 		 }
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_leave_product_converToCart', 'leave_product_converToCart' );
add_action( 'wp_ajax_nopriv_leave_product_converToCart', 'leave_product_converToCart' );

function leave_product_converToCart() {

	  global $woocommerce;  
		$id  = $_POST['id'];  
		foreach($_POST["id"] as $id){
			$products = 	getProductsByID($id);
			print_r($products);
  					//	$sql = "DELETE FROM `$tablename` WHERE id = '$id'";
					//	$wpdb->query($sql);
					$woocommerce->cart->add_to_cart($products[0]['product_id']);
				  
 		 }
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_leave_product_Export', 'leave_product_Export' );
add_action( 'wp_ajax_nopriv_leave_product_Export', 'leave_product_Export' );
function leave_product_Export() {
//	echo $downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
	$CSVurl = plugin_dir_path( __FILE__ ). 'assets/leave.csv'; 
	
	global $woocommerce;  
	$leaveId = $_POST["leaveId"];
	 $leaveData = get_leave_by_id($leaveId);
	$userId     = $leaveData['user_id']; //string value use: %s 

	$user = get_user_by( 'ID', $userId );
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Style

$heading = array(
	'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14,
			'name'  => 'Verdana'
	));
	$styleArray = array(
		'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FF0000'),
				'size'  => 9,
				'name'  => 'Verdana'
		));
		$totalSection = array(
			'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 8,
					'name'  => 'Verdana'
			));

	 $backgroundColor = 	array(
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'd5d5d5')
				));

	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($heading); 
	


 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Price leave')
->setCellValue('A2', 'CREATED BY')
->setCellValue('A3', 'Name : '.$user->first_name.' '.$user->last_name)
->setCellValue('A4', 'Company : '.get_user_meta( $user->ID, 'company_name' , true ))
->setCellValue('A5', 'Email : '.$user->user_email)
->setCellValue('A6', 'Cell : '.get_user_meta( $user->ID, 'mobile' , true ));
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

 // Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0) 
->setCellValue('D2', 'END USER DETAILS')
->setCellValue('D3', 'End User : '.$leaveData['enduser_name'])
->setCellValue('D4', 'Contact Person: '.$leaveData['enduser_contact_person'])
->setCellValue('D5', 'User Contact : '.$leaveData['enduser_contact'])
->setCellValue('D6', 'User Email : '.$leaveData['enduser_email'])
->setCellValue('D7', 'Address : '.$leaveData['enduser_address']);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D2')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);




// $companyName = get_option( 'company_name' );

// $objPHPExcel->setActiveSheetIndex(0)
// ->setCellValue('A7', 'Price leave for planning and information purposes only and is not a binding offer from'.$companyName);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:E7');
// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A7')->getAlignment()->applyFromArray(
// 	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
// );

$timestamp = strtotime($leaveData['cdate']);
		 $date = 	date("d-M-Y", $timestamp);
  $leave_id = 	 'NS00'.$leaveId; 
	$leave_name = 	$leaveData['leave_name'];
	$leave_description = 	$leaveData['leave_description'];
	$days = get_option( 'delete_time' );
	$timestamp = strtotime($leaveData['cdate'].$days.'day');
  $validDate = 	date("d-M-Y", $timestamp);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A8',  'leave DETAILS')
->setCellValue('A9',  'Date : '.$date)
->setCellValue('A10', 'leave ID : '.$leave_id)
->setCellValue('A11', 'leave Name : '.$leave_name)
->setCellValue('A12', 'leave Description : '.$leave_description)
->setCellValue('A13', 'Valid Till : '.$validDate);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A8')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);


$rowNumber2 = 0;
$rowNumber = 14;
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowNumber, 'Product Number')
            ->setCellValue('B'.$rowNumber, 'Product Name')
            ->setCellValue('C'.$rowNumber,'Unit Price')
            ->setCellValue('D'.$rowNumber,'Qty')
						->setCellValue('E'.$rowNumber,'Total Price');

						$objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber)->applyFromArray($backgroundColor); 
 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle($rowNumber)->getAlignment()->applyFromArray(
							array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
						);
			 foreach($_POST["id"] as $id){
								if($id == 'on'){
									continue;
								}
								$allProduct =  getProductsByID($id);
								$product = wc_get_product( $allProduct[0]['product_id'] ); 
								//print_r($product);
								//die();
							 $totalQty = getTotalQty($allProduct[0]['product_id'], $leaveId);
							 $qty = $totalQty[0]['totalQty'];
							 $productQty =  $qty != ''  ?  $qty  : 1;
							 // $productTotalPrice = $product->get_price() * $productQty; 
							 // $subtotal = $subtotal + $productTotalPrice;
					
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

// Add some data
$rowNumber2 = $rowNumber + 1;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowNumber2, $product->get_sku())
            ->setCellValue('B'.$rowNumber2, $product->get_name())
            ->setCellValue('C'.$rowNumber2, $without_tax !=0 ? $without_tax : $product->get_price())
            ->setCellValue('D'.$rowNumber2, $productQty)
						->setCellValue('E'.$rowNumber2, $without_tax !=0 ? $without_taxTotalPrice : $productTotalPrice);
		
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber2)->getNumberFormat()->setFormatCode('@');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$rowNumber2)->getNumberFormat()->setFormatCode('#');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$rowNumber2)->getNumberFormat()->setFormatCode('#');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');

	 $rowNumber++;
						
	 }
	 $grandTotal = $subtotalTax + $subtotal;
	 $rowNumber3 = $rowNumber2 + 1;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber3, 'SubTotal')
							 ->setCellValue('E'.$rowNumber3, $subtotal);
							 
							 
							 $rowNumber4 =	 $rowNumber2+2;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber4, 'leaved Tax')
							 ->setCellValue('E'.$rowNumber4, $subtotalTax);
							 $rowNumber5 =	 $rowNumber2+3;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber5, 'Grand Total')
							 ->setCellValue('E'.$rowNumber5,  $grandTotal);

		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber3)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber4)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber5)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber3)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber4)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber5)->applyFromArray($totalSection);

		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber3)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber4)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber5)->getNumberFormat()->setFormatCode('#,##0.00');

  $baseRow = 5;

	$rowNumber5 = $rowNumber2 + 5;
	// $rowNumber6 = $rowNumber2 + 5;
	$ErowNumber5 = $rowNumber5 + 3;
	//   $a = 'A'.$rowNumber5;
	//  $h = 'H'.$rowNumber5;
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber5.':E'.$ErowNumber5);
	
  // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A16:H17');
	// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A18:H18');
	// $objPHPExcel->setActiveSheetIndex(0)->removeColumn('A','B');
  
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

// $companyName = get_option( 'company_name' );

// $objPHPExcel->setActiveSheetIndex(0)
// ->setCellValue('A'.$rowNumber5, 'Price leave for planning and information purposes only and is not a binding offer from'.$companyName);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber5.':E'.$rowNumber5);
// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->applyFromArray(
// 	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
// );
$rowNumber6 = $rowNumber5 - 1;

$companyName = get_option( 'company_name' );

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$rowNumber6, 'Price leave for planning and information purposes only and is not a binding offer from '.$companyName);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber6.':E'.$rowNumber6);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber6)->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);
$objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber6)->applyFromArray($styleArray);

    $leave_footer = get_option( 'leave_export_footer' );  
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowNumber5,$leave_footer);


    // $leave_footer = get_option( 'leave_export_footer' );  
		// $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowNumber5,$leave_footer);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.csv',  $CSVurl));

echo 'success'; 			
   
	wp_die(); // this is required to terminate immediately and return a proper response
}





add_action( 'wp_ajax_leave_product_Export_as_Pdf', 'leave_product_Export_as_Pdf' );
add_action( 'wp_ajax_nopriv_leave_product_Export_as_Pdf', 'leave_product_Export_as_Pdf' );
function leave_product_Export_as_Pdf() {
//	echo $downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
  $PDFurl = plugin_dir_path( __FILE__ ). 'assets/leave.pdf';
	// header('Content-type: text/csv');
	// header('Content-disposition: attachment;filename="'. $PDFurl .'"');
		global $woocommerce;  
		$leaveId = $_POST["leaveId"];
 		$leaveData = get_leave_by_id($leaveId);
		$userId     = $leaveData['user_id']; //string value use: %s 

		$user = get_user_by( 'ID', $userId ); 
 	 
 				ob_start();
 		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>leave</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		</head>
 <body>
   <div class="leave" style="font-size: 14px;page-break-inside: auto"> 
  	 <h3 style="text-align:center">Price leave</h3>
		 <div style="width:40%; float:left" >
 		<table style="width:100%">
		  <tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">CREATED BY</th>
  			</tr>
		  <tr>
 				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Name:</th>
 				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $user->first_name.' '.$user->last_name; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Company:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo get_user_meta( $user->ID, 'company_name' , true ); ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Email:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $user->user_email; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Cell:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo get_user_meta( $user->ID, 'mobile' , true ); ?></td>
 			</tr>
		</table>
 	</div>
	 <div style="width:60%; float:left" >
		<table style="width:100%">
	   	<tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">END USER DETAILS</th>
  		 </tr>
 		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">End User</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['enduser_name']; ?></td>
 			</tr>
		  <tr>
 				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Contact Person</th>
 				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['enduser_contact_person']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Contact Number</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['enduser_contact']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Email</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['enduser_email']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Address</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['enduser_address']; ?></td>
 			</tr>
		</table>
	</div>  
	 <div style="width:100%;clear:both;" >
	 <table style="width:35%"> 
	 <tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">leave DETAILS</th>
  		 </tr>
				<tr>
	 				<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Date</th>
					 <td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php 
						  $timestamp = strtotime($leaveData['cdate']);
						 echo	date("d-M-Y", $timestamp);

 ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">leave ID:</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo 'NS00'.$leaveId; ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">leave Name:</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['leave_name'] ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">leave Description</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $leaveData['leave_description'] ?></td>
	 			</tr>
			  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
	 			</tr><tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Valid Till</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php $days = get_option( 'delete_time' ); $timestamp = strtotime($leaveData['cdate'].$days.'day');
						 echo	date("d-M-Y", $timestamp);   ?></td>
	 			</tr>
			</table>
 </div>
 <div class="products" style="width:100%;margin-top: 10px">
		<table border="1" style="width:100%;border-collapse: collapse"> 
		  <tr>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;width:20%">Product Numer</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;width:45%">Description</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: right;width:10%">Unit Price</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;;width:10%;text-align: center">Qty</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: right;">Total Price</th>
			 </tr>
			 <?php
			 print_r($_POST["id"]);
			 foreach($_POST["id"] as $id){
				 if($id == 'on'){
						continue;
				 }
				$allProduct =  getProductsByID($id);
				 $product = wc_get_product( $allProduct[0]['product_id'] ); 
				 //print_r($product);
				 //die();
				$totalQty = getTotalQty($allProduct[0]['product_id'], $leaveId);
				$qty = $totalQty[0]['totalQty'];
				$productQty =  $qty != ''  ?  $qty  : 1;
				// $productTotalPrice = $product->get_price() * $productQty; 
				// $subtotal = $subtotal + $productTotalPrice;

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
		  <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo  $product->get_sku() != '' ? $product->get_sku()  : ''; ?></td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $product->get_name(); ?></td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $without_tax !=0 ? number_format($without_tax,2) : number_format($product->get_price(), 2); ?></td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center"><?php echo $productQty; ?></td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $without_tax !=0 ? number_format($without_taxTotalPrice,2) : number_format($productTotalPrice, 2); ?></td>
			 </tr>
			 <?php } ?>
			 <!-- <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">AIR-PWR-CORD-SA</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">ASA 5506-X with FirePOWER services, 8GE, AC, DES</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center">1</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
 			</tr>
			 <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">RV320-WB-K9-G5</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">ASA 5506-X with FirePOWER services, 8GE, AC, DES</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center;">1</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
 			</tr> -->
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">Subtotal</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" ><?php echo  number_format($subtotal, 2); ?></td> 
 			</tr>
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">leaved Tax</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" > <?php echo number_format($subtotalTax,2); ?></td> 
 			</tr>
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">Grand Total</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" ><?php echo number_format($subtotalTax + $subtotal, 2); ?></td> 
 			</tr>
		  
		</table>
		</div>
		<div class="note" style="text-align: center;width:100%;clear:both;margin-top: 10px">
	    <p style="color:red;margin: 5px">Price leave for planning and information purposes only and is not a binding offer from <?php echo get_option( 'company_name' ); ?></p>
		</div>
		<div style="width:100%;margin-top:10px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
		 <p><?php echo get_option( 'leave_export_footer' ); ?></p>
		</div>
 </div>
 </body>
 </html>

<?php
 $html = ob_get_clean();
 $html = stripslashes($html);

		if(isset($_POST["id"])){
 			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);

			// (Optional) Setup the paper size and orientation
			$dompdf->set_paper('A4', 'portrait');
			// $dompdf->set_paper("A4", "portrait");

			// Render the HTML as PDF
			$dompdf->render();
			$output = $dompdf->output();
			file_put_contents($PDFurl, $output);
			// Output the generated PDF to Browser
	   //	$dompdf->stream("sample.pdf");
		}

		echo 'success';
 			
   
	wp_die(); // this is required to terminate immediately and return a proper response
}
// add_action('init', 'leave_product_Export_as_Pdf');

add_action( 'wp_ajax_leave_product_CSVEmail', 'leave_product_CSVEmail' );
add_action( 'wp_ajax_nopriv_leave_product_CSVEmail', 'leave_product_CSVEmail' );
function leave_product_CSVEmail() {
	$downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
	$CSVurl = plugin_dir_path( __FILE__ ). 'assets/file.csv';
	header('Content-type: text/csv');
	header('Content-disposition: attachment;filename="'. $CSVurl .'"');
	  global $woocommerce;  
		$id  = $_POST['id'];  
		if(isset($_POST["id"]))
{
 $array = [];
		foreach($_POST["id"] as $id){
			$products = 	getProductsByID($id);

	     $array[] = $products[0] ; 
						  
			}   
		$fp = fopen($CSVurl , 'w');
 	 if($fp === FALSE) {
				die('Failed to open temporary file');
		}
 		for ($i=0; $i < count($array); $i++) { 
 				fputcsv($fp, $array[$i]);
		} 
		fclose($fp);
	}
	
	$attachments = array(WP_CONTENT_DIR . $downloadLink);
	$headers = 'From: My Name <myname@mydomain.com>' . "\r\n";
	wp_mail('hossaincse2@gmail.com', 'subject', 'message', $headers, $attachments);
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}

function getProductsByID($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave_products";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}


add_action( 'wp_ajax_product_get_by_id', 'product_get_by_id' );
add_action( 'wp_ajax_nopriv_product_get_by_id', 'product_get_by_id' );

function product_get_by_id() {
	global $wpdb;

	$tablename = $wpdb->prefix . "leave_products";

	$productID  = $_POST['productID'];  
	$leaveId  = $_POST['leaveId'];  
	$product = wc_get_product( $productID );

	$productName = $product->get_name(); 
	$productPrice = $product->get_price();
	$getQty = getTotalQty($productID, $leaveId); 
	$qty = $getQty[0]['totalQty'];
  $productQty = $qty + 1;
	$productTotalPriceByID = $productPrice * $productQty;
	
	// echo $sql = "INSERT INTO `$tablename` (`leave_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values ('$leaveId', '$productID', '$productName','$productQty', '$productPrice', '$productTotalPrice')";
  if(empty(productIdCheckInleave($productID,$leaveId))){
		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`leave_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $leaveId, $productID, $productName,$productQty, $productPrice, $productTotalPriceByID);
	}else{ 
	 $sql =  $wpdb->prepare( "UPDATE `$tablename`
		SET `qty` = '$productQty',
				`total_price` = '$productTotalPriceByID'
		WHERE  `leave_id` = %d AND `product_id` = %d", $leaveId,$productID);
	}

	$wpdb->query($sql);

	ob_start();

	$allProducts = allGetProducts($leaveId);
	$subtotal = 0;
	foreach($allProducts as $productItem){
		$product = wc_get_product( $productItem['product_id'] ); 
		$totalQty = getTotalQty($productItem['product_id'], $leaveId);
		$qty = $totalQty[0]['totalQty'];
		$productQty =  $qty != ''  ?  $qty  : 1;
		// $productTotalPrice = $product->get_price() * $productQty; 
		// $subtotal = $subtotal + $productTotalPrice;

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
	<div class="productListBody">  
             <div class="product" id="remove<?php echo $productItem['id']; ?>"> 
								<div  class="product-removal"> 
									<div class="checkBox">
											 <input value="<?php echo $productItem['id']; ?>"  type="checkbox">
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
									<div class="product-price text-right"><?php echo $without_tax !=0 ? number_format($without_tax,2) : number_format($product->get_price(), 2); ?></div>
									<div class="product-quantity text-right">
										<input type="text" data-id="<?php echo $productItem['id']; ?>" value="<?php echo $productQty; ?>" min="1">
                	</div> 
                    <input type="hidden" class="tax-amount" value="<?php echo number_format($tax_amount,2); ?>">
                    <input type="hidden" class="sub-tax-amount" value="<?php echo number_format($totalTax,2); ?>">
 									<div class="product-line-price"><?php echo $without_tax !=0 ? number_format($without_taxTotalPrice,2) : number_format($productTotalPrice, 2); ?></div>
						     </div>
	<?php }		 ?>
	   <div class="totals">
             <div class="totals-item">
               <label>Subtotal</label>
               <div class="totals-value" id="cart-subtotal"> <?php echo  number_format($subtotal, 2); ?></div>
             </div>
             <div class="totals-item">
                  <label>Tax</label>
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
	<?php
	 $listCard = ob_get_clean();
	 
	 echo $listCard;
 	// echo json_encode($product);

	wp_die(); // this is required to terminate immediately and return a proper response
}


function productIdCheck($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave_products";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function productIdCheckInleave($product_id,$leave_id){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave_products";
	$sql = "Select * from $tablename where `product_id` = '$product_id' AND leave_id = '$leave_id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function getTotalQty($productId, $leaveId){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave_products";
	$sql = "SELECT product_id,SUM(qty) as totalQty FROM $tablename Where leave_id = '$leaveId' and  product_id = $productId GROUP BY product_id;";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function allGetProducts($leaveId){
	global $wpdb;
	$tablename = $wpdb->prefix . "leave_products";
	$sql = "Select * from $tablename Where leave_id = '$leaveId'  Group By product_id Order by id ASC";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}
