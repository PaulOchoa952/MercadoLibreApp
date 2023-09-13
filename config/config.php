
<?php

define("CLIENT_ID", "AVoR07DsfnKXExr4SdtvWOGQuI9DhLiK-AHG1Nfzj9mAJU53l5HwSSWwazjdg0lixJg3GOA1dYcuL9iD");
define("TOKEN_MP", "TEST-8442717403041729-091219-2b3a33ba7f01a00cf12a9175d12cc429-656272140");
define("CURRENCY","MXN");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>


