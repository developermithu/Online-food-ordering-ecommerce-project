<?php
include 'lib/Session.php';
Session::init();

if (!isset($_SESSION['ORDER_ID'])) {
    header('location: index');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        .success-page {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        h1 {
            font-size: 42px;
            color: green;
        }

        a {
            font-size: 30px;
            font-weight: 900;
            background: orange;
            padding: 10px 25px;
            border-radius: 38px;
            margin-top: 39px;
            display: block;
            width: 150px;
            text-align: center;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="success-page">
        <h1> Your order has been placed. </h1>
        <h2> Your order id is: <b><?php echo $_SESSION['ORDER_ID']; ?></b> </h2>
        <a href="index">Back Home</a>
    </div>

    <?php unset($_SESSION['ORDER_ID']); ?>

</body>

</html>