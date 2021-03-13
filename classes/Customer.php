<?php

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');
include_once($filePath . '/../helpers/function.php');

include_once($filePath . '/../smtp/PHPMailerAutoload.php');

class Customer
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //============ Customer ===========//
    public function getCustomer()
    {
        $query = "SELECT * FROM `tbl_customer` ORDER BY `id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getUserDetailsForOrder()
    {
        $userId = Session::get('userId');
        $query = "SELECT * FROM `tbl_customer` WHERE `id` = '$userId' ";
        $result = $this->db->select($query);
        return $result;
    }


    //============ Delivery Boy ===========//
    public function getDeliveryBoy()
    {
        $query = "SELECT * FROM `delivery_boy` ORDER BY `name` ASC ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getDeliveryBoyById($edit_id)
    {
        $edit_id = $this->fm->validation($edit_id);
        $query   = "SELECT * FROM `delivery_boy` WHERE `id` = '$edit_id' ";
        $result  = $this->db->select($query);
        return $result;
    }

    // Active Delivery Boy
    public function deactiveDeliveryBoy($deactive_id)
    {
        $deactive_id = $this->fm->validation($deactive_id);
        $deactive_id = mysqli_real_escape_string($this->db->link, $deactive_id);
        $query = "UPDATE `delivery_boy` SET `status` = '1' WHERE `id` = '$deactive_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Deactive Delivery Boy
    public function activeDeliveryBoy($active_id)
    {
        $active_id = $this->fm->validation($active_id);
        $active_id = mysqli_real_escape_string($this->db->link, $active_id);
        $query = "UPDATE `delivery_boy` SET `status` = '0' WHERE `id` = '$active_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Delete 
    public function deleteDeliveryBoy($delete_id)
    {
        $delete_id = $this->fm->validation($delete_id);
        $delete_id = mysqli_real_escape_string($this->db->link, $delete_id);
        $query = "DELETE FROM `delivery_boy` WHERE `id` = '$delete_id' ";
        $result = $this->db->delete($query);
        return $result;
    }

    // Order Details
    public function addOrderDetails($data, $totalPrice)
    {
        $name     = $this->fm->validation($data['name']);
        $email    = $this->fm->validation($data['email']);
        $mobile   = $this->fm->validation($data['mobile']);
        $zip      = $this->fm->validation($data['zip']);
        $address  = $this->fm->validation($data['address']);
        $payment_type = $this->fm->validation($data['payment_type']);
        $userId    = Session::get('userId');

        $query = "INSERT INTO `tbl_order` (`user_id`, `name`, `email`, `mobile`, `address`, `total_price`, `zip`, `payment_status`, `payment_type`, `order_status`) VALUES ( '$userId', '$name', '$email', '$mobile', '$address', '$totalPrice', '$zip', 'Pending', '$payment_type', '1')";
        $result = $this->db->insert($query);

        $insert_id = mysqli_insert_id($this->db->link);
        $_SESSION['ORDER_ID'] = $insert_id;
        $cartArr   = getUserCartFullDetails();
        foreach ($cartArr as $key => $value) {
            $price = $value['price'];
            $qty    = $value['qty'];
            $tp     = $value['price'] * $value['qty'];
            $query = "INSERT INTO `order_details` (`order_id`, `dish_details_id`, `price`, `qty`) VALUES ('$insert_id', '$key', '$tp', '$qty')";
            $result = $this->db->insert($query);
        }

        if ($result == true) {
            $login = Session::get('userLogin');
            if ($login == true) {
                $query = "DELETE FROM `tbl_cart` WHERE `user_id` = '$userId' ";
                $this->db->delete($query);
            } else {
                unset($_SESSION['cart']);
            }

            $email = Session::get('userEmail');

            if ($payment_type == 'cod') {
                $html  = orderEmail($insert_id);
                $this->fm->send_email($email, $html, 'Order Placed');  //must be include smtp file
                echo '<script>window.location = "success"; </script>';
            }
            if ($payment_type == 'paytm') {
                $userId = Session::get('userId');
                $paytm_oid = $insert_id . '_' . $userId;
                $html = '<form method="post" action="pgRedirect.php" name="paymentForm"> 
                <input id="ORDER_ID" tabindex="1" maxlength="20" size="20"
                                name="ORDER_ID" autocomplete="off"
                                value="' . $paytm_oid . '">
                            <input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="' . $userId . '"><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"><input id="CHANNEL_ID" tabindex="4" maxlength="12"
                                size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
                            <input title="TXN_AMOUNT" tabindex="10"
                                type="text" name="TXN_AMOUNT"
                                value="' . $totalPrice . '">
                            <input value="CheckOut" type="submit"	onclick="">
            </form>
            <script type="text/javascript">
			document.paymentForm.submit();
		</script>';
                echo $html;
            } //scriprt must used

        }
    }

    // Update user proflie
    public function updateUserProfile($data, $file)
    {
        $short_description = trim(strip_tags($data['short_description']));
        $name                      = $this->fm->validation($data['name']);
        $mobile                    = $this->fm->validation($data['mobile']);
        $userId                     = Session::get('userId');

        // image upload proccess
        $permited    = array('jpg', 'jpeg', 'png');
        $file_name  = $file['image']['name'];
        $file_size     = $file['image']['size'];
        $file_tmp     = $file['image']['tmp_name'];

        $div          = explode('.', $file_name);
        $file_ext     = strtolower(end($div));
        $unique_img   = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_img = 'media/user/' . $unique_img;  // final image

        if (!empty($file_name)) { //image upload korle
            if ($file_size > 1048567) {
                $msg = '<span class="text-danger ml-2">Image size should be less than <b>1MB!</b></span>';
                return $msg;
            } else if (in_array($file_ext, $permited) === false) {
                $msg = '<span class="text-danger ml-2"> You can upload only: <b>' . implode(', ', $permited) . '</b>!</span>';
                return $msg;
            } else {
                // remove old image
                $query = "SELECT `image` FROM `tbl_customer` WHERE `id` = '$userId' ";
                $result = $this->db->select($query);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $old_image = $row['image'];
                        if ($old_image != "") {
                            unlink($old_image);
                        }
                    }
                }

                move_uploaded_file($file_tmp, $uploaded_img);
                $query = "UPDATE `tbl_customer` SET `name` = '$name', `mobile` = '$mobile', `short_description` = '$short_description', `image` = '$uploaded_img' WHERE `id` = '$userId' ";
                $result = $this->db->update($query);
                if ($result) {
                    // succes msg here
                }
                return $result;
            }
        } else { //image update hobe na
            $query = "UPDATE `tbl_customer` SET `name` = '$name', `mobile` = '$mobile', `short_description` = '$short_description' WHERE `id` = '$userId' ";
            $result = $this->db->update($query);
            if ($result) {
                // succes msg here
            }
            return $result;
        }
    }


    //======================= Customer Order ===================//
    // Customer Order Details
    public function getOrderDetails()
    {
        $query = "SELECT `tbl_order`.*, `order_status`.`status` AS `order_status_name` FROM `tbl_order`, `order_status` WHERE `tbl_order`.`order_status` = `order_status`.`id` ORDER BY `tbl_order`.`id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getOrderDetailsByDeliveryBoyId($deliveryBoyId)
    {
        $query = "SELECT `tbl_order`.*, `order_status`.`status` AS `order_status_name` FROM `tbl_order`, `order_status` WHERE `tbl_order`.`order_status` = `order_status`.`id` AND `tbl_order`.`order_status` != '4' AND `tbl_order`.`delivery_boy_id` = '$deliveryBoyId' ORDER BY `tbl_order`.`id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }
}//customer class