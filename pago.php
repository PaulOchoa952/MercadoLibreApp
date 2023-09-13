<!-- conexión con la bd msalas-->
<?php

  require 'config/config.php';
  require 'config/database.php';
  require 'vendor/autoload.php';
  MercadoPago\SDK::setAccessToken(TOKEN_MP);

  $preference = new MercadoPago\Preference();
  $productos_mp = array();
  $db = new Database();
  $con = $db->conectar();

  $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

  $lista_carrito =  array();

  
  if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, ? as cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$cantidad, $clave]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
        $lista_carrito[] = $producto; // Agregar el producto al arreglo
    }
} else{
    header("location: index.php");
    exit;
}



?>
<!-- fin conexión con la bd --msalas-->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" 
    crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY;
    ?>"></script>
</head>
<body>
<!-- Paul implemento el header de boostrap -->

<header data-bs-theme="dark">
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Tienda Online</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="#" class="nav-link active">Catalogo</a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
            </li>

        </ul>
        <a href="carrito.php" class="btn btn-primary">
          Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
        </a>

      </div>
    </div>
  </div>
</header>

<!--Contenido-->

<main>
    <div class="container">
        <div class ="row">
            <div class="col-6">
                <h4>Detalles de Pago</h4>
                <div class ="row">
                      <div class="col-12">
                        <div id="paypal-button-container"></div>
                      </div>
                </div>

                <div class ="row">
                      <div class="col-12">
                        <div class="checkout-btn"></div>
                      </div>
                </div>
            </div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                if($lista_carrito == null){
                                    echo '<tr><td colspan="5" class="text-center"><b>No hay productos en el carrito</b></td></tr>';
                                }else{
                                    $total = 0;
                                    foreach($lista_carrito as $producto){
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $descuento = $producto['descuento'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $precio_desc * $cantidad;
                                        $total += $subtotal;

                                        $item = new MercadoPago\Item();
                                        $item->id = $_id;
                                        $item->title = $nombre;
                                        $item->quantity = $cantidad;
                                        $item->unit_price = $precio_desc;
                                        $item->currency_id = "MXN";
                                        array_push($productos_mp,$item);
                                        unset($item);
                                    ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td>
                                        <div id="subtotal_<?php echo $_ide; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div>
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td colspan="2"><p class= "h3 text-end" id="total" ><?php echo MONEDA . number_format($total,2,'.',','); ?></p></td>
                                </tr>
                            <?php }?>
                            
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

</main>

<?php
    $preference->items =$productos_mp;
    $preference->back_urls = array(
        "success" => "http://localhost/MercadoLibreApp/captura.php",
        "failure" => "http://localhost/MercadoLibreApp/fallo.php"
    );
    $preference->auto_return = "approved";
    $preference->binary_mode = true;

     $preference->save();
?>

<!--Murgo-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>

    

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
                            value:  <?php echo $total; ?>
                        }
                    }]
                });
            },
            onApprove: function(data, actions){
                let url = 'clases/captura.php'
                actions.order.capture().then(function (detalles){
                    console.log(detalles);
                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type' : 'application/json'
                        },
                        body: JSON.stringify({
                            detalles : detalles
                        })
                    }).then(function(response){
                        window.location.href="completado.php?key=" + detalles['id'];
                    })
                });
            },
            onCancel: function(data){
                alert("Pago declinado");
                console.log(data);
            }
        }).render('#paypal-button-container')

        const mp = new MercadoPago('TEST-2ae8a428-f617-4088-9390-9df5dff14530', {
            locale: 'es-MX'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con Mercado Pago'
            }
        })
    </script>
</body>
</html>