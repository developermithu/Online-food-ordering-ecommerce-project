<?php

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');


class Proccess
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //============= Coupon Code ==============//
    public function getCouponCode()
    {
        $query = "SELECT * FROM `tbl_coupon` ORDER BY `id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    // deactive  
    public function deactive($deactive_id)
    {
        $deactive_id = $this->fm->validation($deactive_id);
        $deactive_id = mysqli_real_escape_string($this->db->link, $deactive_id);
        $query = "UPDATE `tbl_coupon` SET `status` = '1' WHERE `id` = '$deactive_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // active 
    public function active($active_id)
    {
        $active_id = $this->fm->validation($active_id);
        $active_id = mysqli_real_escape_string($this->db->link, $active_id);
        $query = "UPDATE `tbl_coupon` SET `status` = '0' WHERE `id` = '$active_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Delete Category
    public function deleteCouponCode($delete_id)
    {
        $delete_id = $this->fm->validation($delete_id);
        $delete_id = mysqli_real_escape_string($this->db->link, $delete_id);
        $query = "DELETE FROM `tbl_coupon` WHERE `id` = '$delete_id' ";
        $result = $this->db->delete($query);
        return $result;
    }


    //============= Slider ==============//
    public function getSlider()
    {
        $query = "SELECT * FROM `tbl_slider` ORDER BY `id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAllSlider()
    {
        $query = "SELECT * FROM `tbl_slider` WHERE `status` = '0' ORDER BY `id` ASC ";
        $result = $this->db->select($query);
        return $result;
    }

    // deactive  
    public function deactiveSlider($deactive_id)
    {
        $deactive_id = $this->fm->validation($deactive_id);
        $deactive_id = mysqli_real_escape_string($this->db->link, $deactive_id);
        $query = "UPDATE `tbl_slider` SET `status` = '1' WHERE `id` = '$deactive_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // active 
    public function activeSlider($active_id)
    {
        $active_id = $this->fm->validation($active_id);
        $active_id = mysqli_real_escape_string($this->db->link, $active_id);
        $query = "UPDATE `tbl_slider` SET `status` = '0' WHERE `id` = '$active_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Delete 
    public function deleteSlider($delete_id)
    {
        // remove old image
        $query = "SELECT `image` FROM `tbl_slider` WHERE `id` = '$delete_id' ";
        $result = $this->db->select($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $old_image = $row['image'];
                unlink($old_image);
            }
        }

        $delete_id = $this->fm->validation($delete_id);
        $delete_id = mysqli_real_escape_string($this->db->link, $delete_id);
        $query = "DELETE FROM `tbl_slider` WHERE `id` = '$delete_id' ";
        $result = $this->db->delete($query);
        return $result;
    }

    // Add Slider 
    public function addSlider($data)
    {
        $title           = $this->fm->validation($data['title']);
        $sub_title   = $this->fm->validation($data['sub_title']);
        $link            = $this->fm->validation($data['link']);
        $link_text   = $this->fm->validation($data['link_text']);

        // image upload proccess
        $permited    = array('jpg', 'jpeg', 'png');
        $file_name  = $_FILES['image']['name'];
        $file_size     = $_FILES['image']['size'];
        $file_tmp     = $_FILES['image']['tmp_name'];

        $div          = explode('.', $file_name);
        $file_ext     = strtolower(end($div));
        $unique_img   = substr(md5(time()), 0, 10) . '-' . $file_name;
        $uploaded_img = 'media/slider/' . $unique_img;   //STORE_DISH_IMAGE = define()

        if ($file_name == '') {
            $msg = '<span class="text-danger ml-2"><b>Oops!</b> image not uploaded!</span>';
            return $msg;
        } else if ($file_size > 1048567) {
            $msg = '<span class="text-danger ml-2"> Image size should be less than <b>1MB</b> !</span>';
            return $msg;
        } else if (in_array($file_ext, $permited) === false) {
            $msg = '<span class="text-danger ml-2"> You can upload only: <b>' . implode(', ', $permited) . '</b>!</span>';
            return $msg;
        } else {
            $query = "SELECT * FROM `tbl_slider` WHERE `title` = '$title' ";
            $result = $this->db->select($query);
            if ($result == true) {
                $msg = '<span class="text-danger ml-2"><b>Oops!</b> slider already added!</span>';
                return $msg;
            } else {
                move_uploaded_file($file_tmp, $uploaded_img);
                $query = "INSERT INTO `tbl_slider` (`image`, `title`, `sub_title`, `link`, `link_text`) VALUES ('$uploaded_img', '$title', '$sub_title', '$link', '$link_text')";
                $this->db->insert($query);
            }
        }
    }
}//category