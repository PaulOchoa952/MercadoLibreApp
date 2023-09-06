<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AVoR07DsfnKXExr4SdtvWOGQuI9DhLiK-AHG1Nfzj9mAJU53l5HwSSWwazjdg0lixJg3GOA1dYcuL9iD&locale=es_MX&currency=MXN"></script>
</head>

<body>
    <div id="paypal-button-container">

    </div>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'black',
                shape: 'rect',
                label: 'paypal'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100
                        }
                    }]
                });
            },
            onApprove: function(data, actions){
                actions.order.capture().then(function (detalles){
                    window.location.href="completado.html"
                });
            },
            onCancel: function(data){
                alert("Pago declinado");
                console.log(data)
            }
        }).render('#paypal-button-container')
    </script>
</body>

</html>