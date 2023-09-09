<!-- conexión con la bd msalas-->
<?php

  require 'config/config.php';
  require 'config/database.php';
  $db = new Database();
  $con = $db->conectar();

  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);



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
        <a href="checkout.php" class="btn btn-primary">
          Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
        </a>

      </div>
    </div>
  </div>
</header>
<!-- FIN->Paul O. implemento el header de boostrap -->

<!-- Inicio ->Paul implementar la primer card de boostra -->
<main>
    <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach($resultado as $row){?>
          <div class="col">
            <div class="card shadow-sm h-75 d-flex flex-column justify-content-between">
              <?php
              $id = $row ['id'];
              $imagen = "images/productos/" . $id . "/principal.jpg";

              if(!file_exists($imagen)){
                $imagen = "images/no-photo.jpg";
              }
              ?>
               <div class="img-container d-flex align-items-center">
              <img src="<?php echo $imagen; ?>" class="img-fluid" >
              </div>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                <p class="card-text">$ <?php echo number_format($row['precio'],2,'.',','); ?></p>
              
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                  <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                  </div>
                  <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>,'<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                </div>
              </div>
            </div>
          </div> 
        <?php } ?>
      </div>
    </div>
</main>
<!-- Fin ->Paul implementar la primer card de boostrap -->
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