<?php
require("../connexiondb.php");
$sql = $db->prepare("SELECT * FROM restaurant");
$sql->execute([]);
$restaurants = $sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <form class="d-flex gap-5" role="search">
        <div class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="quoi" class="col-form-label">Quoi ?</label>
          </div>
          <div class="col-auto">
            <input type="search" id="quoi" class="form-control" placeholder="Spécialité"
              aria-describedby="passwordHelpInline">
          </div>
        </div>
        <!-- box 2 -->
        <div class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="ou" class="col-form-label">Où ?</label>
          </div>
          <div class="col-auto">
            <input type="search" id="ou" class="form-control" placeholder="Ville" aria-describedby="passwordHelpInline">
          </div>
        </div>
      </form>
    </div>
  </nav>
  <!-- hero section -->
  <div class="container my-5">
    <div class="d-flex">
      <!-- restaurant -->
      <div class="restaurant">
        <div>
          <h1 class="fw-semibold"><span class="header">Les restos</span> à Paris</h1>
          <p class="paragraphe">Envie de nouveaux goûts ? Découvre les restaurants à proximité.</p>
        </div>

        <?php
        foreach ($restaurants as $restaurant) {
          $image = "data:" . $restaurant["Type_Photo"] . ";base64," . base64_encode($restaurant["Photo_Res"]);
        ?>
        <!-- card start -->
        <div class="card mb-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="<?= $image ?>" class="img-fluid rounded-start" alt="<?= $restaurant['Nom_Res'] ?>">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">
                  <?= $restaurant['Nom_Res'] ?>
                </h5>
                <p class=" card-text"><?= $restaurant['Cartier'] ?></p>
                <p class="header"><?= $restaurant['Ville'] ?></p>

                <a href="./details.php?id=<?= $restaurant['IdRes'] ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
        <!-- card end -->
        <?php
        }
        ?>


      </div>
      <!-- map -->
    </div>
  </div>
  <script src=" ../js/script.js"></script>
</body>

</html>