<?php
require("./connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
if (isset($_GET['id'])) {
  // offre id :
  $idOffre = (int)$_GET['id'];
  $sql = $db->prepare("SELECT * FROM offres O INNER JOIN restaurant R ON O.idRes=R.IdRes WHERE idOffre = ?");
  $sql->execute([$idOffre]);
  $offre = $sql->fetch();
  if (empty($offre)) {
    header('location:offres.php');
  }
  if (isset($_POST['valide'])) {
    $sql = $db->prepare("UPDATE offres SET Activation=1 WHERE idOffre=?");
    $sql->execute([$idOffre]);
    $message = 'offre valide';
  } else if (isset($_POST['novalider'])) {
    $sql = $db->prepare("UPDATE offres SET Activation=0 WHERE idOffre=?");
    $sql->execute([$idOffre]);
    $message = 'offre no valide';
  }
} else {
  header('location:offres.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | offre details</title>
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
            <a class="nav-link text-light" href="offres.php">Liste des offres</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container my-5">
    <div class="my-4">
      <a href="./offres.php" class="btn btn-primary">Go back</a>
    </div>
    <?php if (isset($message)) {
    ?>
    <div class="alert alert-info" role="alert">
      <?= $message ?>
    </div>
    <?php
    } ?>
    <div>
      <div class="card text-center">
        <img src="./images/Offres/<?= $offre['image'] ?>" class="card-img-top" alt="offre image">
        <div class="card-body">
          <h5 class="card-title"><span class="header">N° :</span> <?= $offre['idOffre'] ?></h5>
          <p class="card-text"><span class="header">Description :</span> <?= $offre['Des'] ?></p>
          <p class="card-text"><span class="header">Statue :</span> <?= $offre['statue'] ?></p>
          <p class="card-text"><span class="header">Restaurant :</span> <?= $offre['Nom_Res'] ?></p>
          <!-- form validation -->
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            confirmation
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmer offre</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Confirmer offre ou no !
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <form action="" method="post">
                    <input type="submit" name="valide" class="btn btn-primary" value="valider">
                    <input type="submit" name="novalider" class="btn btn-danger" value="no valider">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src=" ./js/bootstrap.min.js"></script>

</body>

</html>