<?php

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');


class Dish
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //============= Dish Details ==============//
    public function getDishAttribute($dish_id)
    {
        $query = "SELECT * FROM `tbl_dish_details` WHERE `dish_id` = '$dish_id' AND `status` = '0' ORDER BY `price` ASC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getDishByCategory($id)
    {
        $query = "SELECT * FROM `tbl_dish` WHERE `category_id` = '$id' AND `status` = '0' ORDER BY `dish` ASC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getDishData()
    {
        $query = "SELECT `tbl_dish`.*, `tbl_category`.`catName` FROM `tbl_dish`, `tbl_category` WHERE `tbl_dish`.`category_id` = `tbl_category`.`id` ORDER BY `id` DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getDishDetailsById($edit_id)
    {
        $query = "SELECT * FROM `tbl_dish` WHERE `id` = '$edit_id' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getCategoryData()
    {
        $query = "SELECT * FROM `tbl_category` ORDER BY `catName` ASC ";
        $result = $this->db->select($query);
        return $result;
    }

    // deactive  
    public function deactiveDish($deactive_id)
    {
        $deactive_id = $this->fm->validation($deactive_id);
        $deactive_id = mysqli_real_escape_string($this->db->link, $deactive_id);
        $query = "UPDATE `tbl_dish` SET `status` = '1' WHERE `id` = '$deactive_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // active 
    public function activeDish($active_id)
    {
        $active_id = $this->fm->validation($active_id);
        $active_id = mysqli_real_escape_string($this->db->link, $active_id);
        $query = "UPDATE `tbl_dish` SET `status` = '0' WHERE `id` = '$active_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Delete 
    public function deleteDish($delete_id)
    {
        // remove old image
        $query = "SELECT `image` FROM `tbl_dish` WHERE `id` = '$delete_id' ";
        $result = $this->db->select($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $old_image = $row['image'];
                unlink($old_image);
            }
        }

        $delete_id = $this->fm->validation($delete_id);
        $delete_id = mysqli_real_escape_string($this->db->link, $delete_id);
        $query = "DELETE FROM `tbl_dish` WHERE `id` = '$delete_id' ";
        $result = $this->db->delete($query);
        return $result;
    }

    //===========  Add Dish =========//
    public function addDish($data)
    {
        $category       = $this->fm->validation($data['category']);
        $type               = $this->fm->validation($data['type']);
        $dish               = $this->fm->validation($data['dish']);
        $dish_details = $data['dish_details'];

        // image upload proccess
        $permited    = array('jpg', 'jpeg', 'png');
        $file_name  = $_FILES['image']['name'];
        $file_size     = $_FILES['image']['size'];
        $file_tmp     = $_FILES['image']['tmp_name'];

        $div          = explode('.', $file_name);
        $file_ext     = strtolower(end($div));
        $unique_img   = substr(md5(time()), 0, 10) . '-' . $file_name;
        $uploaded_img = 'media/dish/' . $unique_img;   //STORE_DISH_IMAGE = define()

        if ($category == '') {
            $msg = '<span class="text-danger ml-2"><b>Oops!</b> category not selected!</span>';
            return $msg;
        } else if ($type == '') {
            $msg = '<span class="text-danger ml-2"><b>Type value is required!</b></span>';
            return $msg;
        } else if ($dish == '') {
            $msg = '<span class="text-danger ml-2"><b>Dish value is required!</b></span>';
            return $msg;
        } else if ($dish_details == '') {
            $msg = '<span class="text-danger ml-2"><b>Dish details is required!</b></span>';
            return $msg;
        } else if ($file_name == '') {
            $msg = '<span class="text-danger ml-2"><b>Oops!</b> image not uploaded!</span>';
            return $msg;
        } else if ($file_size > 1048567) {
            $msg = '<span class="text-danger ml-2"> Image size should be less than <b>1MB</b> !</span>';
            return $msg;
        } else if (in_array($file_ext, $permited) === false) {
            $msg = '<span class="text-danger ml-2"> You can upload only: <b>' . implode(', ', $permited) . '</b>!</span>';
            return $msg;
        } else {
            $query = "SELECT * FROM `tbl_dish` WHERE `dish` = '$dish' ";
            $result = $this->db->select($query);
            if ($result == true) {
                $msg = '<span class="text-danger ml-2"><b>Oops!</b> dish already added!</span>';
                return $msg;
            } else {
                move_uploaded_file($file_tmp, $uploaded_img);
                $query = "INSERT INTO `tbl_dish` (`category_id`, `type`, `dish`, `dish_details`, `image`) VALUES ('$category', '$type',  '$dish', '$dish_details', '$uploaded_img')";
                $result = $this->db->insert($query);

                // For Attribute insert in tbl_dish_details tables
                $dish_id = mysqli_insert_id($this->db->link);
                $attributeArray = $_POST['attribute'];
                $priceArray     = $_POST['price'];
                $statusArray    = $_POST['status'];
                foreach ($attributeArray as $key => $value) {
                    $attribute = $value;
                    $price     = $priceArray[$key];
                    $status    = $statusArray[$key];
                    $query = "INSERT INTO `tbl_dish_details` (`dish_id`, `attribute`, `price`, `status`) VALUES ('$dish_id', '$attribute', '$price', '$status')";
                    $result = $this->db->insert($query);
                }

                if ($result) {
                    $msg = '<span class="text-success ml-2"><b>Welldone!</b> Dish added successfully!</span>';
                    return $msg;
                } else {
                    $msg =  '<span class="text-danger ml-2"><b>Something went wrong!</b></span>';
                    return $msg;
                }
            }
        }
    }

    //===========  Update Dish =========//
    public function updateDish($data, $file, $edit_id)
    {
        $category       = $this->fm->validation($data['category']);
        $type               = $this->fm->validation($data['type']);
        $dish               = $this->fm->validation($data['dish']);
        $dish_details = trim($data['dish_details']);

        // image upload proccess
        $permited    = array('jpg', 'jpeg', 'png');
        $file_name  = $file['image']['name'];
        $file_size     = $file['image']['size'];
        $file_tmp     = $file['image']['tmp_name'];

        $div          = explode('.', $file_name);
        $file_ext     = strtolower(end($div));
        $unique_img   = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_img = 'media/dish/' . $unique_img;  // final image

        if ($category == '') {
            $msg = '<span class="text-danger ml-2"><b>Oops!</b> category not selected!</span>';
            return $msg;
        } else if ($dish == '') {
            $msg = '<span class="text-danger ml-2"><b>Dish value is required!</b></span>';
            return $msg;
        } else if ($type == '') {
            $msg = '<span class="text-danger ml-2"><b>Type value is required!</b></span>';
            return $msg;
        } else if ($dish_details == '') {
            $msg = '<span class="text-danger ml-2"><b>Dish details is required!</b></span>';
            return $msg;
        } else {
            if (!empty($file_name)) {
                if ($file_size > 1048567) {
                    $msg = '<span class="text-danger ml-2">Image size should be less than <b>1MB!</b></span>';
                    return $msg;
                } else if (in_array($file_ext, $permited) === false) {
                    $msg = '<span class="text-danger ml-2"> You can upload only: <b>' . implode(', ', $permited) . '</b>!</span>';
                    return $msg;
                } else {

                    // remove old image
                    $query = "SELECT `image` FROM `tbl_dish` WHERE `id` = '$edit_id' ";
                    $result = $this->db->select($query);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            $old_image = $row['image'];
                            unlink($old_image);
                        }
                    }

                    move_uploaded_file($file_tmp, $uploaded_img);
                    $query = " UPDATE `tbl_dish` SET 
                  `category_id`   = '$category',
                  `type`                = '$type', 
                  `dish`                = '$dish', 
                  `dish_details`  = '$dish_details', 
                  `image`            = '$uploaded_img'
                   WHERE `id`    = '$edit_id' ";
                    $updated = $this->db->update($query);
                    if ($updated) {
                        $msg = '<span class="text-success ml-2">Data updated successfully !</span>';
                        return $msg;
                    } else {
                        $msg = '<span class="text-success ml-2">Something wrong !</span>';
                        return $msg;
                    }
                }
            } else {  //!empty() else   //image update hobe na
                $query = " UPDATE `tbl_dish` SET `category_id` = '$category', `type` = '$type', `dish` = '$dish', `dish_details` = '$dish_details' WHERE `id` = '$edit_id' ";
                $updated = $this->db->update($query);

                // For Attribute Update &  insert in tbl_dish_details tables
                $attributeArray     = $_POST['attribute'];
                $priceArray         = $_POST['price'];
                $statusArray        = $_POST['status'];
                $dish_details_idArr = $_POST['dish_details_id'];
                foreach ($attributeArray as $key => $value) {
                    $attribute = $value;
                    $price     = $priceArray[$key];
                    $status    = $statusArray[$key];

                    if (isset($dish_details_idArr[$key])) {
                        $id = $dish_details_idArr[$key];
                        $query = "UPDATE `tbl_dish_details` SET `attribute` = '$attribute', `price` = '$price', `status` = '$status' WHERE `id` = '$id' ";
                        $result = $this->db->update($query);
                    } else {
                        $query = "INSERT INTO `tbl_dish_details` (`dish_id`, `attribute`, `price`, `status`) VALUES ('$edit_id', '$attribute', '$price', '$status')";
                        $result = $this->db->insert($query);
                    }
                } //foreach

                if ($updated) {
                    $msg = '<span class="text-success ml-2">Data updated successfully !</span>';
                    return $msg;
                } else {
                    $msg = '<span class="text-success ml-2">Something wrong !</span>';
                    return $msg;
                }
            }
        } //firstelse
    } //updateDish


}//dishclass
