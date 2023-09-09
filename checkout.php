<!-- conexión con la bd msalas-->
<?php

  require 'config/config.php';
  require 'config/database.php';
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

<main>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($lista_carrito == null){
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

                        ?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo MONEDA . number_format($precio_desc,2,'.',',');?></td>
                        <td>
                            <input type="number" min= "1" max=10 step="1" value="<?php echo $cantidad?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="">
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $_ide; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div>
                        </td>
                        <td>
                            <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id;?>" data-bs-toogle="modal" data-bs-target="eliminaModal">Eliminar</a>
                        </td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="3" class="text-end"></td>
                        <td colspan="2"><p class= "h3" id="total" ><?php echo MONEDA . number_format($total,2,'.',','); ?></p></td>
                    </tr>
                 <?php }?>
                    
                 
                </tbody>
            </table>
        </div>
        <div class="row">
             <div class="col-md-5 offset-md-7 d-grid gap-2">
                <button class="btn btn-primary btn-lg">
                    Realizar Pago
                </button>
             </div>
        </div>
    </div>
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token){
            
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

       
            
            fetch(url,{
                method: 'POST', 
                body: formData,
                mode: 'cors'                 
            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>

</body>
</html>