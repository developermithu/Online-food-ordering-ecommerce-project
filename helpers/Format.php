<?php

class Format
{
    // visit below down site to know more about date formate
  // https://wordpress.org/support/article/formatting-date-and-time/ 

  public function formatDate($date)
  {
    echo date("j F, Y g:i A", strtotime($date));
  }

  public function formatDate2($date)
  {
    echo date("j M, Y ", strtotime($date));
  }

  public function dateFormat($date){
    $str = strtotime($date);
    return date("d-m-Y", $str);
  }

  public function textShorten($text, $limit = 200)
  {
    $text = $text . " ";
    $text = substr($text, 0, $limit);
    $text = substr($text, 0, strrpos($text, " "));  //text......
    $text = $text . "...";
    return $text;
  }

  public function validation($data)
  {
    $data = trim($data); //avoid space, enter, tab
    $data = strip_tags($data); //avoid html tag <p></p>
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function title()
  {
    $path = $_SERVER['SCRIPT_FILENAME'];           //index.php contact.php
    $title = basename($path, '.php');              // .php bad
    $title = str_replace('_', ' ', $title);        //contact_us.php = Contact Us

    if ($title == 'index') {                       // must be used ==
      $title = 'home';
    } elseif ($title == 'contact') {                 // must be used ==
      $title = 'contact';
    }
    return $title = ucwords($title);
    // ucfirst() first character uppercase
    // ucwords()every words first character uppercase
  }

  public function rand_string()
  {
     $str = str_shuffle('abcdefghijklmnopqrstuvwxyz');
    return $str = substr($str, 0, 15);  // suru theke 15 porjonto 
  }


  public function send_email($email, $html, $subject)
  {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = "www.mithudas77@gmail.com";
    $mail->Password = "*md*105@ritu#";
    $mail->SetFrom("www.mithudas77@gmail.com");
    $mail->addAddress("$email");  //user email
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->SMTPOptions = array('ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => false
    ));
    if ($mail->send()) {
      // echo "Please check your email address.";
    } else {
      //echo "Error occur";
    }
  }
}//format class
