<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');

$db = new Database();

function pr($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($str){
	global $con;
	$str=mysqli_real_escape_string($con,$str);
	return $str;
}

function redirect($link){
	?>
	<script>
	window.location.href='<?php echo $link?>';
	</script>
	<?php
	die();
}

function getUserCart()
{
    global $db;
    $userId = Session::get('userId');

    $arr = array();
    $query = "SELECT * FROM `tbl_cart` WHERE `user_id` = '$userId' ";
    $result = $db->select($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }
}

function getCartTotalPrice()
{
    $cartArr = getUserCartFullDetails();
    $totalPrice = 0;
    foreach ($cartArr as $value) {
        $totalPrice = $totalPrice + ($value['qty'] * $value['price']);
    }
    return $totalPrice;
}

function getSetting()
{
    global $db;
    $query = "SELECT * FROM `tbl_setting` WHERE `id` = '1' ";
    $result = $db->select($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row;
    }
}

function getSale($start, $end)
{
    global $db;
    $query = "SELECT SUM(`total_price`) AS  `total_price` FROM `tbl_order` WHERE `added_on` BETWEEN '$start' AND '$end' AND `order_status` = '4' ";
    $result = $db->select($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_price'];
    }
}

function getDeliveryBoyNameById($id)
{
    global $db;
    $query = "SELECT * FROM `delivery_boy` WHERE `id` = '$id' ";
    $result = $db->select($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['name'] . ' (' . $row['mobile'] . ')';
    } else {
        return 'Not Assign';
    }
}

function manageUserCart($userId, $qty, $attr)
{
    global $db;
    $checkCart = "SELECT * FROM `tbl_cart` WHERE `user_id` = '$userId' AND `dish_details_id` = '$attr' ";
    $result = $db->select($checkCart);
    if ($result == true) {  //mysqli_num_rows>0 hole
        $row = $result->fetch_assoc();
        $cartId = $row['id'];
        $query = "UPDATE `tbl_cart` SET `qty` = '$qty' WHERE `id` = '$cartId' ";
        $db->update($query);
    } else {
        $query = "INSERT INTO `tbl_cart` (`user_id`, `dish_details_id`, `qty`) VALUES ('$userId', '$attr', '$qty')";
        $result = $db->insert($query);
    }
}

function getDishCartStatus()
{
    global $db;
    $cartArr = array();
    $dishDetailsID = array();
    $login = Session::get('userLogin');
    if ($login == true) {
        $getUserCart = getUserCart();
        // $getUserCart = array(); // prev this was comment //87 also
        $cartArr = array();

        // error_reporting(0);   //(do not show error line if we use this)

        foreach ((array) $getUserCart as $list) {
            $dishDetailsID[] = $list['dish_details_id'];
        }
    } else {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $key => $val) {
                $dishDetailsID[] = $key;
            }
        }
    }



    foreach ($dishDetailsID as $id) {
        $query = "SELECT `tbl_dish_details`.`status`, `tbl_dish`.`status` AS `dish_status`, `tbl_dish`.`id` FROM `tbl_dish_details`, `tbl_dish` WHERE `tbl_dish_details`.`id` = '$id' AND `tbl_dish_details`.`dish_id` = `tbl_dish`.`id` ";
        $result = $db->select($query);
        $row = $result->fetch_assoc();
        if ($row['dish_status'] == '1') { //tbl_dish deactive hole
            $id = $row['id'];
            $query = "SELECT `id` FROM `tbl_dish_details` WHERE `dish_id` = '$id' ";
            $result = $db->select($query);
            while ($row2 = $result->fetch_assoc()) {
                removeCartById($row2['id']);
            }
        }
        if ($row['status'] == '1') { //tbl_dish_details deactive hole
            removeCartById($id);
        }
    }
}

function getUserCartFullDetails($attr_id = "")
{
    $cartArr = array();
    $login = Session::get('userLogin');
    if ($login == true) {
        $getUserCart = getUserCart();
        // $getUserCart = array(); // prev this was comment //50 also
        $cartArr = array();
        foreach ((array) $getUserCart as $list) {
            $cartArr[$list['dish_details_id']]['qty'] = $list['qty'];
            $dishDetails = getDishDetailsById($list['dish_details_id']);
            $cartArr[$list['dish_details_id']]['price'] = $dishDetails['price'];
            $cartArr[$list['dish_details_id']]['dish']  = $dishDetails['dish'];
            $cartArr[$list['dish_details_id']]['image'] = $dishDetails['image'];
        }
    } else {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $key => $val) {
                $cartArr[$key]['qty'] = $val['qty'];
                $dishDetails = getDishDetailsById($key);
                $cartArr[$key]['price']    = $dishDetails['price'];
                $cartArr[$key]['dish']     = $dishDetails['dish'];
                $cartArr[$key]['image'] = $dishDetails['image'];
            }
        }
    }
    if ($attr_id != "") {
        return $cartArr[$attr_id]['qty'];
    } else {
        return $cartArr;
    }
}

function getDishDetailsById($id)
{
    global $db;
    $query = "SELECT `tbl_dish`.`dish`, `tbl_dish`.`image`, `tbl_dish_details`.`price` FROM `tbl_dish`, `tbl_dish_details` WHERE `tbl_dish_details`.`id` = '$id' AND `tbl_dish`.`id` = `tbl_dish_details`.`dish_id` ";
    $result = $db->select($query);
    $row = $result->fetch_assoc();
    return $row;
}

function removeCartById($id)
{
    $login = Session::get('userLogin');
    $userId = Session::get('userId');

    if ($login == true) {
        global $db;
        $query = "DELETE FROM `tbl_cart` WHERE `dish_details_id` = '$id' AND `user_id` = '$userId' ";
        $db->delete($query);
    } else {
        unset($_SESSION['cart'][$id]);
    }
}

function getOrderDetails($oid)
{
    global $db;
    $query = "SELECT `order_details`.`price`, `order_details`.`qty`, `tbl_dish_details`.`attribute`, `tbl_dish`.`dish`, `tbl_dish`.`image` FROM `order_details`, `tbl_dish_details`, `tbl_dish` 
    WHERE `order_details`.`order_id` = '$oid' AND `order_details`.`dish_details_id` = `tbl_dish_details`.`id` AND `tbl_dish_details`.`dish_id` = `tbl_dish`.`id`
        ";
    $result = $db->select($query);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getOrderDetailsById($oid)
{
    global $db;
    $query = "SELECT * FROM `tbl_order` WHERE `id` = '$oid' ";
    $result = $db->select($query);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function orderEmail($oid)
{
    global $db;
    $name = Session::get('userName');
    $orderDetails = getOrderDetailsById($oid);
    $order_id     = $orderDetails[0]['id'];
    $total_price  = $orderDetails[0]['total_price'];

    $getOrderDetails = getOrderDetails($oid);

    // echo '<pre>';
    // print_r($getOrderDetails);
    // exit();

    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <style>table td{padding: 0 5px !important;}</style>
</head>
<body>
    <div class="es-wrapper-color">
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="esd-email-paddings" valign="top">

                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr></tr>
                                <tr>
                                    <td class="esd-stripe" esd-custom-block-id="7681" align="center">
                                        <table class="es-header-body" style="background-color: #044767;" width="600" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p35t es-p35b es-p35r es-p35l" align="left">
                                                        <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="340" valign="top"><![endif]-->
                                                        <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="es-m-p0r es-m-p20b esd-container-frame" width="340" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-m-txt-c" align="left">
                                                                                        <a href="http://localhost/food"><img src="https://i.ibb.co/PtwZj8D/enjoy.png" style="margin-top:8px"></a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--[if mso]></td><td width="20"></td><td width="170" valign="top"><![endif]-->
                                                        <table cellspacing="0" cellpadding="0" align="right">
                                                            <tbody>
                                                                <tr class="es-hidden">
                                                                    <td class="es-m-p20b esd-container-frame" esd-custom-block-id="7704" width="170" align="left">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-spacer es-p5b" align="center" style="font-size:0">
                                                                                        <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="border-bottom: 1px solid #044767; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table cellspacing="0" cellpadding="0" align="right">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="left">
                                                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td class="esd-block-text" align="right">
                                                                                                                        <p style="font-size: 18px; line-height: 120%;color:#fff;">Hi, ' . $name . '</p>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p40t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-image es-p25t es-p25b es-p35r es-p35l" align="center" style="font-size:0"><img src="https://tlr.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png" alt style="display: block;" width="120"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10b" align="center">
                                                                                        <h2>Thank You For Your Order!</h2>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10t es-p10b es-p10r es-p10l" bgcolor="#eeeeee" align="left">
                                                                                        <table style="width: 500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td width="90%">
                                                                                                        <h3>Order Number :</h3>
                                                                                                    </td>
                                                                                                    <td width="10%">
                                                                                                        <h3> ' . $oid . ' </h3>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10t es-p10b es-p10r es-p10l" align="left">
                                                                                        <table style="width: 500px;margin-top: 20px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                                                                            <tbody>
                                                                                              <tr>
                                                                                                <th style="padding: 5px 10px 5px 0" width="50%" align="left">Description</th>
                                                                                                <th style="padding: 5px 10px 5px 0" width="50%" align="left">Qty</th>
                                                                                                <th style="padding: 5px 10px 5px 0" width="50%" align="left">Price</th>
                                                                                              </tr>';

    foreach ($getOrderDetails as $list) {

        $html .= '<tr>
                                                                                                    <td style="padding: 5px 10px 5px 0" width="50%" align="left">
                                                                                                        <p>' . $list['dish'] . ' (' . $list['attribute'] . ')</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0" width="50%" align="left">
                                                                                                        <p>' . $list['qty'] . '</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0" width="50%" align="left">
                                                                                                        <p>' . $list['price'] . 'tk</p>
                                                                                                    </td>
                                                                                                </tr>';
    }

    $html .= '</tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p10t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table style="border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;" width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p15t es-p15b es-p10r es-p10l" align="left">
                                                                                        <table style="width: 500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td width="90%">
                                                                                                        <h4>TOTAL</h4>
                                                                                                    </td>
                                                                                                    <td width="10%">
                                                                                                        <h4>' . $total_price . 'tk</h4>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="margin-top: 20px" class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" esd-custom-block-id="7797" align="center">
                                        <table class="es-content-body" style="background-color: #1b9ba3;" width="600" cellspacing="0" cellpadding="0" bgcolor="#1b9ba3" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p35t es-p35b es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p25t" align="center">
                                                                                        <h2 style="color: #ffffff; font-size: 24px;">Get 25% off your next order.</h2>
                                                                                    </td>
                                                                                </tr> 
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" class="es-footer" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" esd-custom-block-id="7684" align="center">
                                        <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p35t es-p40b es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td esdev-links-color="#777777" align="left" class="esd-block-text es-m-txt-c es-p5b">
                                                                                        <p style="color: #777777;">If you have any question about this invoice, simply reply to this email or reach out to our &nbsp;<a target="_blank" href="#" style="color: #1b9ba3;">support team</a> for help.</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>';
    return $html;
}
