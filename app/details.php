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
  <div class="details d-flex justify-content-center align-items-center">
    <h1 class="text-light"><?= $restaurant["Nom_Res"] ?></h1>
  </div>
  <div class="mt-4 container">
    <h5 class="fs-6"><?= $restaurant["Nom_Res"] ?> <span class="paragraphe">à <?= $restaurant["Ville"] ?>,
        <?= $restaurant["Cartier"] ?></span>
    </h5>
    <div class="d-flex align-items-start gap-3 my-4">
      <img src="<?= $image ?>" class="img-fluid rounded" alt="<?= $restaurant["Nom_Res"] ?>">
      <!-- maps -->
      <!-- map -->
      <div id="map" class="col-6 ">
        <a href="https://www.maptiler.com"><img src="https://api.maptiler.com/resources/logo.svg"
            alt="MapTiler logo" /></a>
      </div>
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
  <!-- script js -->
  <script>
  const map = L.map("map").setView([<?php echo $restaurant['C_Latitude']; ?>,
    <?php echo $restaurant['C_Longitude']; ?>
  ], 16); //starting position
  var marker = L.marker([<?php echo $restaurant['C_Latitude']; ?>, <?php echo $restaurant['C_Longitude']; ?>])
    .addTo(map);

  var marker<?php echo $restaurant['IdRes']; ?> = L.marker([<?php echo $restaurant['C_Latitude']; ?>,
    <?php echo $restaurant['C_Longitude']; ?>
  ]).addTo(map);
  marker<?php echo $restaurant['IdRes']; ?>.bindPopup(
    '<?php echo "<div class=" . "info" . "><h3 class=" . "fs-5" . ">" . $restaurant['Nom_Res'] . "</h3><p>" . $restaurant['Ville'] . "</p><p class=\"header\">" . $restaurant['Specialites'] . "</p></div>"; ?>'
  );

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