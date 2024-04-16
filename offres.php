<?php
require("./connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
$sql = $db->prepare("SELECT * FROM offres WHERE Activation=0");
$sql->execute([]);
$offres = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | ajouter offres</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>
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
  <!-- main content -->
  <div class="container my-5">
    <div class="row g-2">
      <?php foreach ($offres as $offre) {
      ?>
      <div class="col">
        <div class="card" style="width: 18rem;">
          <img src="<?= $offre['image'] ?>" class="card-img-top" alt="offre image">
          <div class="card-body">
            <h5 class="card-title">N° : <?= $offre['idOffre'] ?></h5>
            <p class="card-text">Description : <?= $offre['Des'] ?></p>
            <p class="card-text">Statue : <?= $offre['statue'] ?></p>
            <a href="offreDetails.php?id=<?= $offre['idOffre'] ?>" class="stretched-link"></a>
          </div>
        </div>
      </div>
      <?php
      } ?>
    </div>
  </div>
  <script src="./js/bootstrap.min.js"></script>

</body>

</html>