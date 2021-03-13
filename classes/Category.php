<?php

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');


class Category{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function getCategoryList(){
    	$query = "SELECT * FROM `tbl_category` ORDER BY `catName` ASC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getCategoryByStatus(){
    	$query = "SELECT * FROM `tbl_category` WHERE `status` = '0' ORDER BY `catName` ASC LIMIT 5 ";
        $result = $this->db->select($query);
        return $result;
    }

 	// Active Category 
   public function deactiveCategory($deactive_id){
   			$deactive_id = $this->fm->validation($deactive_id);
   			$deactive_id = mysqli_real_escape_string($this->db->link, $deactive_id);
    	  $query = "UPDATE `tbl_category` SET `status` = '1' WHERE `id` = '$deactive_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Deactive Category
        public function activeCategory($active_id){
        $active_id = $this->fm->validation($active_id);
   			$active_id = mysqli_real_escape_string($this->db->link, $active_id);
    	  $query = "UPDATE `tbl_category` SET `status` = '0' WHERE `id` = '$active_id' ";
        $result = $this->db->update($query);
        return $result;
    }

    // Delete Category
        public function deleteCategory($delete_id){
        $delete_id = $this->fm->validation($delete_id);
   			$delete_id = mysqli_real_escape_string($this->db->link, $delete_id);
    	  $query = "DELETE FROM `tbl_category` WHERE `id` = '$delete_id' ";
        $result = $this->db->delete($query);
        return $result;
    }

		// Select category
    public function getCategory($edit_id){
    	  $edit_id = $this->fm->validation($edit_id);
    	  $edit_id = mysqli_real_escape_string($this->db->link, $edit_id);
    	  $query = "SELECT * FROM `tbl_category` WHERE `id` = '$edit_id' ";
        $result = $this->db->select($query);
        return $result;
    }


 }//category