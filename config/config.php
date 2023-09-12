
<?php

define("CLIENT_ID", "AVoR07DsfnKXExr4SdtvWOGQuI9DhLiK-AHG1Nfzj9mAJU53l5HwSSWwazjdg0lixJg3GOA1dYcuL9iD");
define("CURRENCY","MXN");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>


