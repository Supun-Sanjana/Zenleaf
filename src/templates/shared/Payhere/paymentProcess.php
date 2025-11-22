<?php

$merchant_id = "1223126";
$order_id = uniqid();
$amount = 4000;
$currency = "LKR";
$merchant_secret = "MzE3Njc0MDg0MjI3NTA1NjQwOTgyNTU0NDc0MDY0Mzc4NDg2OTA5MA==";
$item=array('jjjjj','kkjkkk');
$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        number_format($amount, 2, '.', '') .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

$valueArray = [];
$valueArray["merchant_id"] = $merchant_id;
$valueArray["order_id"] = $order_id;
$valueArray["amount"] = $amount;
$valueArray["currency"] = $currency;
$valueArray["item"] = $item;
$valueArray["hash"] = $hash;

$jsonObj = json_encode($valueArray);

echo $jsonObj;
