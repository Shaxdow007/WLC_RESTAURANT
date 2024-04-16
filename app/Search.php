<?php
require("../connexiondb.php");
$sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant");
$sql->execute([]);
$restaurants = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | search ville</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-danger ">
    <div class="container justify-content-between">
      <a class="navbar-brand" href="#">
        <img src="../images/eatLogo.png" alt="" width="100px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="Search.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="AjouterOffres.php">Ajouter un Offres</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container my-4">
    <div class="row g-2">
      <?php
      foreach ($restaurants as $restaurant) {
      ?>
      <!-- card start -->
      <div class="col-3">
        <div class="card text-bg-dark">
          <img src="../images/<?= $restaurant['Ville'] ?>.jpg" class="card-img" alt="<?= $restaurant['Ville'] ?>">
          <div class="d-flex justify-content-center align-items-center card-img-overlay">
            <h5 class="card-title"><?= $restaurant['Ville'] ?></h5>
            <a href="./index.php?Ville=<?= $restaurant['Ville'] ?>" class="stretched-link"></a>
          </div>
        </div>
      </div>
      <!-- card end -->
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>