<?php
include("config.php");
include("curl.php");
include("customer.php");

/* DUMMY DATA from Juspay
Array ( [order_id] => 5f1ab932a3177 [status] => CHARGED [status_id] => 21 [signature] => xreMURZxBwRcQKusClWXIqFOSy/AkQFE6lll4HDoj7k= [signature_algorithm] => HMAC-SHA256 )
 */

if($_GET['status']=='CHARGED'){
    echo "Thank you, your order reference is ".$_GET['order_id'];
}else{
    echo 'Something went wrong';
}
