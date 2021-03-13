<?php

class Session
{

  public static function init()
  {
    session_start();
  }

  public static function set($key, $val)
  {
    $_SESSION[$key] = $val;
  }

  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }

  public static function checkSession()
  {
    if (self::get("userLogin") == false) {
      self::destroy();
    }
  }

  public static function checkLogin()
  {
    if (self::get("userLogin") == true) {
      header("location: shop");
    }
  }

  public static function checkAdminSession()
  {
    self::init();
    if (self::get("adminLogin") == false) {
      self::destroy();
      // header("location: admin/login.php");
    }
  }

  public static function checkAdminLogin()
  {
    self::init();
    if (self::get("adminLogin") == true) {
      header("location: admin/index.php");
    }
  }

  public static function destroy()
  {
    session_destroy();
    session_unset();
  }
}
