<?php

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');


class Admin{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function getAdminData($data) {
        $adminUsername = $this->fm->validation($data['adminUsername']);
        $adminPassword = $this->fm->validation($data['adminPassword']);

        $adminUsername = mysqli_real_escape_string($this->db->link, $adminUsername);
    // md5() kora thakle password query er tik upor likte hobe na hole empty password o niye nibe

        if ($adminUsername == "" || $adminPassword == "") {
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Field must not be empty!</strong> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            return $msg;
        } else {

            $adminPassword = mysqli_real_escape_string($this->db->link, md5($adminPassword));
            $query = "SELECT * FROM `tbl_admin` WHERE `adminUsername` = '$adminUsername' AND `adminPassword` = '$adminPassword'  ";
            $result = $this->db->select($query);
            if ($result) {
                $value = $result->fetch_assoc();
                Session::init();
                Session::set('userLogin', true);
                Session::set('adminUsername', $value['adminUsername']);
                Session::set('adminid', $value['adminid']);
                header("location: index.php");
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> Username or Password not matched!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                return $msg;
            }
        }
    }//getAdminData


}//admin class
