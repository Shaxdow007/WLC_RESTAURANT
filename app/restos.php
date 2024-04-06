<?php
require("../connexiondb.php");
// $sql = $db->prepare("SELECT * FROM restaurant");
// $sql->execute([]);
// $restaurants = $sql->fetchAll();
if (isset($_GET['ville'])) {
  $ville = $_GET['ville'];
} else {
  $ville = "Marrakech";
}
if (isset($_POST['Ville'])) {
  $ville = $_POST["Ville"];
}
$sql = $db->prepare("SELECT * FROM restaurant WHERE Ville LIKE '%$ville%'");
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
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
  #map {
    border-radius: 20px;
    height: 100vh;
  }

  .info {
    width: 200px;
  }
  </style>
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <div class="d-flex gap-5">
        <form action="restos.php" method="post" role="search">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="quoi" class="col-form-label">Quoi ?</label>
            </div>
            <div class="col-auto">
              <input type="search" id="quoi" class="form-control" placeholder="Spécialité">
            </div>
          </div>
        </form>
        <form action="restos.php" method="post">
          <!-- box 2 -->
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="ou" class="col-form-label">Où ?</label>
            </div>
            <div class="col-auto">
              <input type="search" id="ou" class="form-control" placeholder="Ville" name="Ville" value="<?= $ville ?>">
            </div>
          </div>
        </form>
      </div>
    </div>
  </nav>
  <!-- hero section -->
  <div class="container my-5">
    <div>
      <!-- restaurant -->
      <div class="restaurant">
        <div>
          <h1 class="fw-semibold"><span class="header">Les restos</span> à
            <?php if (!empty($ville)) {
              echo $ville;
            } else {
              echo "tous";
            } ?>
          </h1>
          <p class="paragraphe">Envie de nouveaux goûts ? Découvre les restaurants à proximité.</p>
        </div>
        <div class="d-flex justify-content-center align-items-start gap-5">
          <div>
            <?php
            foreach ($restaurants as $restaurant) {
              $image = "data:" . $restaurant["Type_Photo"] . ";base64," . base64_encode($restaurant["Photo_Res"]);
            ?>
            <!-- card start -->
            <div class=" card mb-3" style="max-width: 540px;">
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
          <div id="map" class="col-6 ">
            <a href="https://www.maptiler.com"><img src="https://api.maptiler.com/resources/logo.svg"
                alt="MapTiler logo" /></a>
          </div>
        </div>

      </div>
    </div>

  </div>
  </div>
  <script src=" ../js/script.js"></script>
  <script>
  const map = L.map("map").setView([<?php echo $restaurants[0]['C_Latitude']; ?>,
    <?php echo $restaurants[0]['C_Longitude']; ?>
  ], 10); //starting position
  var marker = L.marker([<?php echo $restaurants[0]['C_Latitude']; ?>, <?php echo $restaurants[0]['C_Longitude']; ?>])
    .addTo(map);

  <?php foreach ($restaurants as $res) : ?>
  var marker<?php echo $res['IdRes']; ?> = L.marker([<?php echo $res['C_Latitude']; ?>,
    <?php echo $res['C_Longitude']; ?>
  ]).addTo(map);
  marker<?php echo $res['IdRes']; ?>.bindPopup(
    '<?php echo "<div class=" . "info" . "><h3 class=" . "fs-5" . ">" . $res['Nom_Res'] . "</h3><p>" . $res['Ville'] . "</p><p class=\"header\">" . $res['Specialites'] . "</p></div>"; ?>'
  );
  <?php endforeach; ?>

  L.tileLayer(
    "https://api.maptiler.com/maps/topo-v2/256/{z}/{x}/{y}.png?key=IAKoattdnMh2FDr00Ydx", {
      //style URL
      tileSize: 512,
      zoomOffset: -1,
      minZoom: 1,
      attribution: '<?php echo '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'; ?>',
      crossOrigin: true,
    }
  ).addTo(map);
  </script>

</body>

</html>