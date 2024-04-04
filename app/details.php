<?php
require("../connexiondb.php");
$sql = $db->prepare("SELECT * FROM restaurant WHERE IdRes= ? ");
$sql->execute([$_GET['id']]);
$restaurant = $sql->fetch();
$image = "data:" . $restaurant["Type_Photo"] . ";base64," . base64_encode($restaurant["Photo_Res"]);
// var_dump($restaurant)
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $restaurant["Nom_Res"] ?> - Details </title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <style>
  .details {
    height: 50vh;
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.2)), url("<?= $image ?>");
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    backdrop-filter: blur(120px);
    -webkit-backdrop-filter: blur(5px);
  }
  </style>
</head>

<body>
  <div class="details d-flex justify-content-center align-items-center">
    <h1 class="text-light"><?= $restaurant["Nom_Res"] ?></h1>
  </div>
  <div class="mt-4 container">
    <h5 class="fs-6"><?= $restaurant["Nom_Res"] ?> <span class="paragraphe">à <?= $restaurant["Ville"] ?>,
        <?= $restaurant["Cartier"] ?></span>
    </h5>
    <div class="d-flex my-4">
      <img src="<?= $image ?>" class="img-fluid rounded" alt="<?= $restaurant["Nom_Res"] ?>">
      <!-- maps -->
    </div>
    <div class="w-50">
      <span class="py-1 px-4 bg-info rounded text-light fw-light fs-6">plus de détails :</span>
      <ul class="mt-2 list-group list-group-flush">
        <li class="list-group-item">Restaurant : <span class="header"><?= $restaurant["Nom_Res"] ?></span></li>
        <li class="list-group-item">Ville : <span class="header"><?= $restaurant["Ville"] ?></span></li>
        <li class="list-group-item">Cartier : <span class="header"><?= $restaurant["Cartier"] ?></span></li>
        <li class="list-group-item">Specialites : <span class="header"><?= $restaurant["Specialites"] ?></span></li>
      </ul>
    </div>
  </div>

</body>

</html>