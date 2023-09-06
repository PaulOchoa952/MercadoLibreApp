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
        <a href="carrito.php" class="btn btn-primary">Carrito</a>

      </div>
    </div>
  </div>
</header>
<!-- FIN->Paul O. implemento el header de boostrap -->

<!-- Inicio ->Paul implementar la primer card de boostra -->
<main>
    <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
          <div class="card shadow-sm">
            <img src="images/productos/1/principal.jpg">
            <div class="card-body">
              <h5 class="card-title">Zapatos color cafe.</h5>
              <p class="card-text">$ 599.00</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="" class="btn btn-primary">Detalles</a>
                </div>
                <a href="" class="btn btn-success">Agregar</a>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
</main>
<!-- Fin ->Paul implementar la primer card de boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>
</body>
</html>