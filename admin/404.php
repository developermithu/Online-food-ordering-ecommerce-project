<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>404 Error Page</title>
      <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css"/>
      <style>
         body{
         font-family: 'Rubik', sans-serif;
         }
         .error-box {
         height: 100%;
         position: fixed;
         top: 20%;
         background-color: #fff;
         width: 100%;
         }
         .error-box .error-body {
         padding-top: 5%;
         }
         .error-box .error-title {
         font-size: 210px;
         font-weight: 900;
         line-height: 210px;
         }
         .text-danger {
         color: #f33155!important;
         }
         .error-box h3 {
         line-height: 30px;
         font-size: 21px;
         margin: 10px 0;
         font-weight: 300;
         }
         .btn-rounded {
         border-radius: 60px;
         padding: 7px 18px;
         }
         .btn-danger {
         color: #fff;
         background-color: #f33155;
         border-color: #f33155;
         }
      </style>
   </head>
   <body>
      <div class="error-box">
         <div class="error-body text-center">
            <h1 class="error-title text-danger">404</h1>
            <h3 class="text-uppercase error-subtitle">PAGE NOT FOUND !</h3>
            <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
            <a href="index.php" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to home</a>
         </div>
      </div>
   </body>
</html>