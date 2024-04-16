<?php
require("./connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | ajouter restaurants</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>


<body class="">
  <nav class="navbar navbar-expand-lg bg-danger">
    <div class="container-fluid">
      <a href="https://www.eat.ma/" class="link-dark px-2 fs-4"><img class="w-50" src="./images/eatLogo.png"
          alt="eat"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-light" href="index.php">Ajouter restaurants</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="offres.php">Ajouter offres</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-center bg-light"
        style="height: 100vh;">
        <img class="w-50 mx-auto" src="./images/eatLogoRed.png" alt="eatLogo">
        <p class="text-dark my-4 fs-6">Bonjour dans votre espace d'admin ,commence d'jaouter des restaurants .
        <form action="traitement.php" method="post">
          <button type="submit" class="btn btn-danger btn-sm" name="exit">quitter l'espace d'admin</button>
        </form>
        </p>
      </div>
      <div class="col-sm-12 col-md-6 form-body d-flex justify-content-center align-items-center m-auto "
        style="height: 100vh;">

        <div class="d-flex justify-content-center align-items-center ">

          <div class="form-holder ">
            <div class="form-content m-auto">
              <div class="form-items ">
                <h3 class="">Ajouter un restaurant</h3>
                <p class="">
                  Remplissez les données ci-dessous.</p>
                <form action="traitement.php" method="post" enctype="multipart/form-data">
                  <div class="col-md-12">
                    <input class="form-control" type="text" name="Nom" placeholder="Nom de restaurant" required>
                  </div>

                  <div class="col-md-12">
                    <input class="form-control" type="text" name="Ville" placeholder="Ville" required>
                  </div>
                  <div class="col-md-12">
                    <input class="form-control" type="text" name="Cartier" placeholder="Cartier" required>
                  </div>
                  <div class="col-md-12">
                    <input class="form-control" type="text" name="Specialites" placeholder="Specialites" required>
                  </div>

                  <div class="col-md-12 my-3">
                    <label for="" class="text-dark">Photo de restaurant:</label>
                    <input class="form-control" type="file" accept="image/*" name="Photo" required>
                  </div>

                  <div class="col-md-12">
                    <input class="form-control my-3" type="text" name="Latitude" placeholder="Latitude" required>
                  </div>

                  <div class="col-md-12">
                    <input class="form-control" type="text" name="Longitude" placeholder="Longitude" required>
                  </div>
                  <div class="form-button mt-3">
                    <button id="submit" type="submit" class="btn btn-danger" name="done">Ajouter</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>



  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <script src="./js/bootstrap.min.js"></script>
</body>

</html>