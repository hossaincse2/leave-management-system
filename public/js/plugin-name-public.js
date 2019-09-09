(function ($) {
  //'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
  jQuery(document).ready(function ($) {


    $(document).on('click', '#leaveInsert', function (e) {
      e.preventDefault();
      var userId = $('#userId').val();
      var leaveName = $('#leaveName').val();
      var description = $('#description').val();
      var endUserName = $('#endUserName').val();
      var endUserEmail = $('#endUserEmail').val();
      var endUserContact = $('#endUserContact').val();
      var endUserContactPerson = $('#endUserContactPerson').val();
      var endUserAddress = $('#endUserAddress').val();

      var data = {
        'action': 'leave_insert',
        'userId': userId,
        'leaveName': leaveName,
        'description': description,
        'endUserName': endUserName,
        'endUserEmail': endUserEmail,
        'endUserContact': endUserContact,
        'endUserContactPerson': endUserContactPerson,
        'endUserAddress': endUserAddress,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  console.log(base_url + '/leave?leave-id=' + response);
          //  $('.leaveForm').fadeOut();
          window.location = base_url + '/leave?leave-id=' + response;
          // $('.leaveDetails').fadeIn();
        }

      });
    });
    $(document).on('click', '#leaveEdit', function (e) {
      e.preventDefault();
      var leaveId = $('#leaveId').val();
      var leaveName = $('#leaveName').val();
      var description = $('#description').val();
      var endUserName = $('#endUserName').val();
      var endUserEmail = $('#endUserEmail').val();
      var endUserContact = $('#endUserContact').val();
      var endUserContactPerson = $('#endUserContactPerson').val();
      var endUserAddress = $('#endUserAddress').val();

      var data = {
        'action': 'leave_edit',
        'leaveId': leaveId,
        'leaveName': leaveName,
        'description': description,
        'endUserName': endUserName,
        'endUserEmail': endUserEmail,
        'endUserContact': endUserContact,
        'endUserContactPerson': endUserContactPerson,
        'endUserAddress': endUserAddress,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  console.log(base_url + '/leave?leave-id=' + response);
          //  $('.leaveForm').fadeOut();
          window.location = base_url + '/leave?leave-id=' + response;
          // $('.leaveDetails').fadeIn();
        }

      });
    });

    $(document).on('click', '.leaveDelete', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('tr');

      var data = {
        'action': 'leave_delete',
        'nonce': nonce,
        'leaveId': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $tr.find('td').fadeOut(1000, function () {
            $tr.remove();
          });
        }

      });
    });

    $(document).on('click', '.add_list', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var leaveId = $(this).attr("data-leaveId");
      // var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('tr');

      var data = {
        'action': 'product_get_by_id',
        'productID': id,
        'leaveId': leaveId,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $('.productListBody').html(response);
        }

      });
    });


    $(document).on('click', '.remove-product', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var productId = $(this).attr("data-productId");
      var leaveId = $(this).attr("data-leaveId");
      var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('.product');

      var data = {
        'action': 'leave_product_delete',
        'nonce': nonce,
        'id': id,
        'leaveId': leaveId,
        'productId': productId,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $tr.find('.product-removal').fadeOut(1000, function () {
            $tr.remove();
          });
        }

      });
    });



    $("#checkAll").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#btn_delete').click(function (e) {
      e.preventDefault();

      var id = [];
      $(':checkbox:checked').each(function (i) {
        id[i] = $(this).val();
      });

      if (id.length === 0) //tell you if the array is empty
      {
        alert("Please Select atleast one checkbox");
      }
      
      else {
        if (confirm("Are you sure?")) {
          // your deletion code
     
        var $div = $(this).closest('.leave-cart').find('.card-body').find('.product');
        var data = {
          'action': 'leave_product_multiple_delete',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
            console.log(id);
            for (var i = 0; i < id.length; i++) {
              $('#remove' + id[i]).fadeOut(1000, function () {
                $(this).remove();
                window.location.reload();
              });
            }
          }

        });
      }
      return false; 
      }
    });



    $('#btn_convert').click(function (e) {
      e.preventDefault();

      var id = [];
      $(':checkbox:checked').each(function (i) {
        id[i] = $(this).val();
      });

      if (id.length === 0) //tell you if the array is empty
      {
        alert("Please Select atleast one checkbox");
      }
      else {
        var $div = $(this).closest('.leave-cart').find('.card-body').find('.product');
        var data = {
          'action': 'leave_product_converToCart',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
             // window.location.reload();
             window.location = base_url +'/cart';
           }

        });

      }
    }); 


    $('#leave_clone').click(function (e) {
      e.preventDefault(); 

       var id = $(this).data('id');

         var data = {
          'action': 'leave_clone',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
             // window.location.reload();
             window.location = base_url +'/leave?leave-id=' + response;
           }

        });

     }); 



  $('#btn_export').click(function (e) {
    e.preventDefault();

    var leaveId = $(this).data('id');

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select atleast one checkbox");
    }
    else {
      var $div = $(this).closest('.leave-cart').find('.card-body').find('.product');
      var data = {
        'action': 'leave_product_Export',
        'leaveId': leaveId,
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
           // window.location.reload();
            window.location = plugin_url +'/includes/assets/leave.csv';
         }

      });

    }
  }); 
  $('#btn_export_pdf').click(function (e) {
    e.preventDefault();

   var leaveId = $(this).data('id');

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select atleast one checkbox");
    }
    else {
      var $div = $(this).closest('.leave-cart').find('.card-body').find('.product');
      var data = {
        'action': 'leave_product_Export_as_Pdf',
        'leaveId': leaveId, 
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  window.location.reload();
            // window.location = plugin_url +'/includes/assets/leave.pdf';
            window.open(plugin_url +'/includes/assets/leave.pdf', '_blank');
         }

      });

    }
  }); 

  $('#btn_email').click(function (e) {
    e.preventDefault();

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select atleast one checkbox");
    }
    else {
      var $div = $(this).closest('.leave-cart').find('.card-body').find('.product');
      var data = {
        'action': 'leave_product_CSVEmail',
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response); 

      });

    }
  }); 
});



-$(document).ready(function() {
   
      /* Set rates + misc */
        var taxRate = 0.05;
        var shippingRate = 0.00; 
        var fadeTime = 300;

         /* Assign actions */
-    $(document).on('change','.product-quantity input', function() {
  -      updateQuantity(this);
         updateQtyByajax(this);
        });
     $(document).on('click','.product-removal a', function() {
               removeItem(this);
      });
      function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      // return  Number(nStr).toLocaleString('en');
    } 
        /* Recalculate cart */
    function recalculateCart()
     {
       var subtotal = 0;
       var subtotaltax = 0;
       
      /* Sum up row totals */
      $('.product').each(function () {
         var $price = parseFloat($(this).children('.product-line-price').text().replace(/,/g, ''));  
        //  console.log($price); 
        //  var $subtax = parseFloat($(this).children('.sub-tax-amount').val().replace(',','')); 
         var $subtax = $(this).children('.sub-tax-amount').val();  
        //  console.log($price); 
        //  parseInt($(this).html().replace(',',''));

        if(typeof $subtax !== "undefined"){
         var $getTax = $subtax.replace(/,/g, ''); 
        //  console.log($getTax);

          if($.isNumeric( $getTax ) != false){
            subtotaltax += parseFloat($getTax); 
             
          }
        }

         if($.isNumeric( $price ) != false){
          
          // var getPrice =  $price.replace(',','');
           subtotal += $price;
          //  console.log(subtotal); 
          }
        
          
       });
     

      //  console.log(subtotaltax);
       /* Calculate totals */
      // var tax = subtotal * taxRate;
      // var tax = subtotaltax * subtotaltax;
      var shipping = (subtotal > 0 ? shippingRate : 0);
      var total = subtotal + subtotaltax + shipping;
      var subtotalPrice = subtotal.toFixed(2);
      var subtotalPriceFormating = addCommas(subtotalPrice);
      /* Update totals display */
      $('.totals-value').fadeOut(fadeTime, function() {
        $('#cart-subtotal').html(subtotalPriceFormating);
        $('#cart-tax').html(addCommas(subtotaltax.toFixed(2)));
        $('#cart-shipping').html(shipping.toFixed(2));
        $('#cart-total').html(addCommas(total.toFixed(2)));
        if(total == 0){
          $('.checkout').fadeOut(fadeTime);
        }else{
          $('.checkout').fadeIn(fadeTime);
        }
        $('.totals-value').fadeIn(fadeTime); 
      });
    }
  /* Update quantity */
  function updateQuantity(quantityInput)
  {
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children('.product-price').text().replace(/,/g, ''));
    var $tax = parseFloat(productRow.children('.tax-amount').val()); 
    var quantity = $(quantityInput).val(); 
    var linePrice = price * quantity;
    var Subtotaltax = quantity * $tax;
     console.log('tax' + $tax);
     var singlePrice = addCommas(linePrice.toFixed(2));
     
    /* Update line price display and recalc cart totals */
    productRow.children('.product-line-price').each(function () {
      $(this).fadeOut(fadeTime, function() {
        $(this).text(singlePrice);
        $(this).find('.sub-tax-amount').val(Subtotaltax); 
        recalculateCart(); 
        $(this).fadeIn(fadeTime);
      });
    });  
    /* Update line price display and recalc cart totals */
    productRow.children('.sub-tax-amount').each(function () {
      $(this).fadeOut(fadeTime, function() {
         $(this).val(Subtotaltax); 
        recalculateCart(); 
        $(this).fadeIn(fadeTime);
      });
    });  
  }

  function updateQtyByajax(quantityInput){ 
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children('.product-price').text().replace(/,/g, ''));
    var id = $(quantityInput).data('id');
    var quantity = $(quantityInput).val(); 
    var linePrice = price * quantity;

    var data = {
      'action': 'leave_product_updateByQty',
      'id': id,
      'quantity': quantity,
      'totalPrice': linePrice,
    };
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajax_object.ajax_url, data, function (response) {
      // alert('Got this from the server: ' + response);
      if (response) {
         // window.location.reload();
        }

    });
  }

   /* Remove item from cart */
   function removeItem(removeButton)
    {
      /* Remove row from DOM and recalc cart total */
      var productRow = $(removeButton).parent().parent();
      productRow.slideUp(fadeTime, function() {
        productRow.remove();
        recalculateCart();
      });
    }      

  
});

    

})(jQuery);
