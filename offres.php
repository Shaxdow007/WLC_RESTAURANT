<?php
require("./connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
if (isset($_POST['filter'])) {
  if ($_POST['filter'] === 'tous') {
    $sql = $db->prepare("SELECT * FROM offres O INNER JOIN restaurant R ON O.idRes=R.IdRes");
    $sql->execute([]);
    $offres = $sql->fetchAll();
  } else if ($_POST['filter'] === 'valide') {
    $sql = $db->prepare("SELECT * FROM offres O INNER JOIN restaurant R ON O.idRes=R.IdRes WHERE Activation=1");
    $sql->execute([]);
    $offres = $sql->fetchAll();
  } else if ($_POST['filter'] === 'noValide') {
    $sql = $db->prepare("SELECT * FROM offres O INNER JOIN restaurant R ON O.idRes=R.IdRes WHERE Activation=0");
    $sql->execute([]);
    $offres = $sql->fetchAll();
  }
} else {
  $sql = $db->prepare("SELECT * FROM offres O INNER JOIN restaurant R ON O.idRes=R.IdRes");
  $sql->execute([]);
  $offres = $sql->fetchAll();
}
// var_dump($offres);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | liste des offres</title>
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
  <!-- main content -->
  <div class="container my-5">
    <div class="row g-2">
      <!-- filter form -->
      <form action="" method="post" class="my-3">
        <select class="form-select" name="filter" onchange="this.form.submit()">
          <option value="tous">Tous les offres</option>
          <option value="valide" <?php if (isset($_POST['filter'])) {
                                    if ($_POST['filter'] === 'valide') {
                                      echo 'selected';
                                    }
                                  } ?>>
            offre
            valider
          </option>
          <option value="noValide" <?php if (isset($_POST['filter'])) {
                                      if ($_POST['filter'] === 'noValide') {
                                        echo 'selected';
                                      }
                                    } ?>>offre n'est pas valider</option>
        </select>
      </form>
      <table class="table table-striped table-hover">
        <thead>
          <tr class="text-center">
            <th>N°</th>
            <th>Offre restaurant</th>
            <th>Statue</th>
            <th>Description</th>
            <th>Offre image</th>
            <th>Confirmation</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($offres as $offre) {
          ?> <tr class="text-center">
            <td><?= $offre['idOffre'] ?></td>
            <td><?= $offre['Nom_Res'] ?></td>
            <td><?= $offre['statue'] ?></td>
            <td><?= substr($offre['Des'], 0, 25)  ?> </td>
            <td><img src="./images/Offres/<?= $offre['image'] ?>" class="w-25" alt="offre image"></td>
            <td><a href="offreDetails.php?id=<?= $offre['idOffre'] ?>" class="btn btn-primary">confirmer</a></td>
          </tr>
          <?php
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="./js/bootstrap.min.js"></script>

</body>

</html>