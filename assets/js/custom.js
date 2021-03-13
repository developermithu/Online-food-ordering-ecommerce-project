
function customer_registration(){
    $('.field_error').html("");
    var regName        = $('#regName').val();
    var regEmail         = $('#regEmail').val();
    var regMobile       = $('#regMobile').val();
    var regPassword = $('#regPassword').val();
    var is_error = "";

    if (regName == "") {
        $('#regNameError').html('Name is required!');
         is_error = "yes";
    }
     if (regEmail == "") {
        $('#regEmailError').html('Email is required!');
        is_error = "yes";
    }   
     if (regMobile == "") {
        $('#regMobileError').html('Mobile number is required!');
        is_error = "yes";
    }
     if (regPassword == "") {
        $('#regPasswordError').html('Password is required!');
        is_error = "yes";
    }
if (is_error =="") {
    $('#final_result').html('Please wait...');
    $('#regBtn').attr('disabled', true);
    $.ajax({
        url: SITE_PATH+"ajax/user_registration",            
        type: "post",
        data: {regName:regName, regEmail:regEmail, regMobile:regMobile, regPassword:regPassword},
        success: function (response){
            $('#final_result').html('');
            $('#regBtn').attr('disabled', false);

            if (response == 'unvalid') {
                $('#regEmailError').html('<span class="text-danger"><b>Oops!</b> Email address not valid.</span>');
            }
            if (response == 'exist') {
                $('#regEmailError').html('<span class="text-danger"><b>Oops!</b> Email already registered.</span>');
            }
            if (response == 'success') {
                $('#final_result').html('<span class="text-success"><b>Thanks!</b> for your registration. Please check your email id for verify.</span>');
                $('#regForm')[0].reset();
            }
        }
    });
}
}

// Customer Login
function customer_login(){
    $('.field_error').html("");
    var user_email          = $('#user_email').val();
    var user_password  = $('#user_password').val();
    var checkout_page  = $('#checkout_page').val();
    var is_error = "";

    if (user_email == "") {
        $('#user_email_error').html('Please type your email!');
         is_error = "yes";
    } 
     if (user_password == "") {
        $('#user_password_error').html('Please type your password!');
        is_error = "yes";
    }
if (is_error =="") {
    $.ajax({
        url: SITE_PATH+"ajax/user_login",            
        type: "post",
        data: {user_email:user_email, user_password:user_password},
        success: function (response){
            if (response == 'unvalid') {
                $('#user_email_error').html('<span class="text-danger"><b>Oops!</b> Email address is not valid.</span>');
            }
            if (response == 'email_not_match') {
                $('#user_email_error').html('<span class="text-danger"><b>Oops!</b> Email not matched.</span>');
            }
            if (response == 'pwd_not_match') {
                $('#user_password_error').html('<span class="text-danger"><b>Oops!</b> Password not matched !</span>');
            }
            if (response == 'not_verified') {
                $('#final_error').html('<span class="text-danger">Please verifiy your email address.</span>');
            }
            if (response == 'success') {
                if (checkout_page == 'yes') {
                    window.location.href = SITE_PATH+'checkout';
                }else{
                    window.location.href = SITE_PATH+'my_account';
                    $('#login_form')[0].reset();
                }
            }
        }
    });
}
}

// Contact Us
function send_message(){
    $('.field_error').html("");
    var name        = $('#name').val();
    var email         = $('#email').val();
    var subject       = $('#subject').val();
    var message = $('#message').val();
    var is_error = "";

    if (name == "") {
        $('#name_error').html('Please type your name!');
         is_error = "yes";
    }
     if (email == "") {
        $('#email_error').html('Please type your email!');
        is_error = "yes";
    }   
     if (subject == "") {
        $('#subject_error').html('Subject field is required!');
        is_error = "yes";
    }
     if (message == "") {
        $('#message_error').html('Please type your message!');
        is_error = "yes";
    }
if (is_error =="") {
    $.ajax({
        url: SITE_PATH+"ajax/contact_us",            
        type: "post",
        data: {name:name, email:email, subject:subject, message:message},
        success: function (response){
            if (response == 'unvalid') {
                $('#email_error').html('<span class="text-danger"><b>Oops!</b> Email address is not valid.</span>');
            }
            if (response == 'success') {
                $('#final_result').html('<span class="text-success"><b>Thanks!</b> for your message. We will reply ASAP.</span>');
                $('#contact_form')[0].reset();
            }
        }
    });
}
}

// Forgot Password
function forgot_password_btn(){
    $('.field_error').html("");
    var email     = $('#email').val();
    var is_error = "";

    if (email == "") {
        $('#email_error').html('Please type your email !');
         is_error = "yes";
    }
if (is_error =="") {
    $('#final_result').html('Please wait...');
    $('#forgot_btn').attr('disabled', true);
    $.ajax({
        url: SITE_PATH+"ajax/get_forgot_pwd",            
        type: "post",
        data: {email:email},
        success: function (response){
            $('#final_result').html('');
            $('#forgot_btn').attr('disabled', false);
            if (response == 'unvalid') {
                $('#email_error').html('<span class="text-danger"><b>Oops!</b> Email address is not valid.</span>');
            }
            if (response == 'not_verified') {
                $('#email_error').html('<span class="text-danger">Please verifiy your email address.</span>');
            }
            if (response == 'email_not_match') {
                $('#email_error').html('<span class="text-danger"><b>Oops!</b> Email not matched.</span>');
            }
            if (response == 'success') {
                $('#final_result').html('<span class="text-danger"> Please check your email address for new password.</span>');
                $('#forgot_form')[0].reset();
            }
        }
    });
}
}

//======= For Shop Page =======//
function set_checkbox(id) {
    var dish_cat = $('#dish_cat').val();
    var check = dish_cat.search(":" + id);
    if (check != '-1') {
        dish_cat = dish_cat.replace(":" + id, "");
    } else {
        dish_cat = dish_cat + ":" + id;
    }
    $('#dish_cat').val(dish_cat);
    $('#dish_cat_form')[0].submit();
}

function setFoodType(type) {
    $('#type').val(type);
    $('#dish_cat_form')[0].submit();
}

function setSearch() {
    var search = $('#search').val();
    $('#search_type').val(search);
    $('#dish_cat_form')[0].submit();
}


function add_to_cart(id, type){
var qty = $('#qty'+id).val();
var attr = $('input[name="attr'+id+'"]:checked').val(); 
var is_attr_checked = "";

if (typeof attr === 'undefined') {
    is_attr_checked = 'no';
}

if (qty>0 && is_attr_checked != 'no') {
$.ajax({
    url: SITE_PATH+"ajax/add_to_cart",       
    type: 'post',
    data: {qty:qty, attr:attr, type:type},
    success: function(result){
        var data = $.parseJSON(result);
        Swal.fire( 'Congratulation!', 'Product added successfully!', 'success' );
          $('#shop_added_msg_'+attr).html('(Added -'+qty+') ');
        //   var totalCartNumber = $('#totalCartNumber').html();
        //   totalCartNumber++;
          $('#totalCartNumber').html(data.totalCartNumber);
          $('#totalPrice').html(data.totalPrice+' tk');

          var tpl = data.totalPrice;
          if (data.totalCartNumber == 1) {
              var tp = qty*data.price;
              var html = ' <div class="shopping-cart-content"><ul id="cart_url"><li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="dish-img" src="'+SITE_PATH+'admin/'+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+'</a></h4><h6>Qty: '+qty+'</h6><span>'+tp+' tk</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick=delete_cart("'+attr+'")><i class="far fa-trash-alt"></i></a></div></li> </ul> <div class="shopping-cart-total"><h4>Shipping : <span>Free</span></h4><h4>Total : <span class="shop-total" id="shopTotal">'+tp+' tk</span></h4> </div><div class="shopping-cart-btn"><a href="'+SITE_PATH+'cart">view cart</a><a href="'+SITE_PATH+'checkout">checkout</a></div></div>';
              $('.header-cart').append(html);
          }else{
            var tp = qty*data.price;
            $('#attr_'+attr).remove();
            var html = '<li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="dish-img" src="'+SITE_PATH+'admin/'+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+'</a></h4><h6>Qty: '+qty+'</h6><span>'+tp+' tk</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick=delete_cart("'+attr+'")><i class="far fa-trash-alt"></i></a></div></li>';
            $('#cart_url').append(html);
            $('#shopTotal').html(tpl+ 'tk');
          }
    }
});
}else{
  Swal.fire( 'Error!', 'Please select qty & dish item!', 'error' );
}
}

function delete_cart(id, is_type){
    $.ajax({
        url: SITE_PATH+"ajax/add_to_cart",       
        type: 'post',
        data: 'attr='+id+'&type=delete',
        success: function(result){
            if (is_type == 'reload') {
                window.location.href = window.location.href;
            }else{
            var data = $.parseJSON(result);
              $('#totalCartNumber').html(data.totalCartNumber);
              $('#totalPrice').html(data.totalPrice+' tk');
              $('#shop_added_msg_'+id).html('');

              if (data.totalCartNumber == 0) {
                $('.shopping-cart-content').remove();
              }else{
                var tpl = data.totalPrice;
                $('#shopTotal').html(tpl+ 'tk');
                $('#attr_'+id).remove();
              }
            }
        }
    });
}

// Change password
function change_password(){
    $('.field_error').html("");
    var old_pwd = $('#old_pwd').val();
    var new_pwd = $('#new_pwd').val();
    var is_error = "";

    if (old_pwd == "") {
        $('#old_pwd_error').html('Old password is required!');
         is_error = "yes";
    }
     if (new_pwd == "") {
        $('#new_pwd_error').html('New password is required!');
        is_error = "yes";
    }
if (is_error =="") {
    $('#final_result').html('Please wait...');
    $('#pwd_change_btn').attr('disabled', true);
    $.ajax({
        url: SITE_PATH+"ajax/update_password",            
        type: "post",
        data: {old_pwd:old_pwd, new_pwd:new_pwd},
        success: function (response){
            $('#final_result').html('');
            $('#pwd_change_btn').attr('disabled', false);

            if (response == 'pwd_not_match') {
                $('#old_pwd_error').html('<span class="text-danger"><b>Oops!</b> password not matched.</span>');
            }
            if (response == 'success') {
             Swal.fire( 'Password!', 'Password has been updated successfully!', 'success' );
                $('#pwd_form')[0].reset();
            }
        }
    });
  }
}

// Coupon Code
function apply_coupon(){
    var coupon_code = $('#coupon_code').val();

    if (coupon_code == "") {
        $('#coupon_error').html('<b>Empty!</b> please enter coupon code!');
    }else{
        $.ajax({
        url: SITE_PATH+"ajax/get_coupon",            
        type: "post",
        data: {coupon_code:coupon_code},
        success: function (result){
            var result = $.parseJSON(result);
            
            if (result.status == 'success') {
                Swal.fire( 'Apply Coupon!', result.msg, 'success' );
                $('#coupon_code_form')[0].reset();
            } 
            if (result.status == 'error') {
                $('#coupon_error').html(result.msg);
            }
           
        }
     });
    }
}