// Add Category
function addCategory(){
    var catName      = $('#catName').val();
    var order_number = $('#order_number').val();

    $.ajax({
        url: 'get_category.php',
        type: 'post',
        data: {catName:catName, order_number:order_number},
        success: function (result){
              if ( result == "success" ) {
                window.location.href = "category.php";
              }else{
                  $('#showMsg').html(result);
              }
        }
    });
}

// Update Category
function updateCategory(){
    var updateCatname     = $('#updateCatname').val();
    var updateOrdernumber = $('#updateOrdernumber').val();
    var hidden_id = $('#hidden_id').val();

    $.ajax({
        url: 'get_update_category.php',
        type: 'post',
        data: {updateCatname:updateCatname, updateOrdernumber:updateOrdernumber, hidden_id:hidden_id},
        success: function (result){
              if ( result == "updated" ) {
                window.location.href = "category.php";
              }else{
                  $('#showMsg').html(result);
              }
        	}
    });
}

// Add Delivery Boy
function addDeliveryBoy(){
    var name      = $('#name').val();
    var mobile = $('#mobile').val();
    var password = $('#password').val();

    $.ajax({
        url: 'get_delivery_boy.php',
        type: 'post',
        data: {name:name, mobile:mobile, password:password},
        success: function (result){
              if ( result == "added" ) {
                window.location.href = "delivery_boy.php";
              }else{
                  $('#showMsg').html(result);
              }
        }
    });
} 

// Update Delivery Boy
function updateDeliveryBoy(){
    var name   = $('#name').val();
    var mobile = $('#mobile').val();
    var hidden_id = $('#hidden_id').val();

    $.ajax({
        url: 'get_update_delivery_boy.php',
        type: 'post',
        data: {name:name, mobile:mobile, hidden_id:hidden_id},
        success: function (result){
              if ( result == "updated" ) {
                window.location.href = "delivery_boy.php";
              }else{
                  $('#showMsg').html(result);
              }
        	}
    });
} 

// Add Coupon Code
function addCoupon(){
    var coupon_code    = $('#coupon_code').val();
    var coupon_value   = $('#coupon_value').val();
    var coupon_type    = $('#coupon_type').val();
    var cart_min_value = $('#cart_min_value').val();
    var expired_on     = $('#expired_on').val();

    $.ajax({
        url: 'get_coupon_code.php',
        type: 'post',
        data: {coupon_code:coupon_code, coupon_value:coupon_value, coupon_type:coupon_type, cart_min_value:cart_min_value, expired_on:expired_on},
        success: function (result){
              if ( result == "added" ) {
                window.location.href = "coupon_code.php";
              }else{
                  $('#showMsg').html(result);
              }
        }
    });
}  
