<?php

require 'vendor/autoload.php';
MercadoPago\SDK::setAccessToken('TEST-8442717403041729-091219-2b3a33ba7f01a00cf12a9175d12cc429-656272140');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();

$item->id = '0001';
$item->title = 'Producto CDP';
$item->quantity = 1;
$item->unit_price = 150.00;
$item->currency_id = "MXN";

$preference->items = array($item);

$preference->back_urls = array(
    "success" => "http://localhost/MercadoLibreApp/captura.php",
    "failure" => "http://localhost/MercadoLibreApp/fallo.php"
);

$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>MercadoPago</h3>
    <div class="checkout-btn"></div>
    <script>
        const mp = new MercadoPago('TEST-2ae8a428-f617-4088-9390-9df5dff14530', {
            locale: 'es-MX'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'
            }
        })
    </script>
</body>
</html>