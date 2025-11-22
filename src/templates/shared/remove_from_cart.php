<?php
session_start();
if(isset($_POST['product_id'], $_SESSION['cart'][$_POST['product_id']])){
    unset($_SESSION['cart'][$_POST['product_id']]);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
