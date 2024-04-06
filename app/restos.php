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
$sql = $db->prepare("SELECT * FROM restaurant");
$sql->execute([]);
$restaurants = $sql->fetchAll();
$sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant  ");
$sql->execute([]);
$Villes = $sql->fetchAll();
// Touts Specialites de ville
$sql = $db->prepare("SELECT DISTINCT Specialites FROM restaurant WHERE Ville = ?");
$sql->execute([$ville]);
$Specialites = $sql->fetchAll();
if (isset($_POST["Ville"])) {
  extract($_POST);
  // Les reatau par Ville et Specialite
  $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ? AND Specialites =? ");
  $sql->execute([$Ville, $Specialite]);
  $restaurants = $sql->fetchAll();
}
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css"
    integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
  #map {
    border-radius: 20px;
    height: 100vh;
  }

  .info {
    width: 200px;
  }

  .selectize-control.single .selectize-input.input-active,
  .selectize-input {
    width: 400px;
    padding: 10px 20px;
  }
  </style>
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <div class="d-flex gap-5">
        <form action="" method="post" class="d-flex gap-5" role="search">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="quoi" class="col-form-label">Quoi ?</label>
            </div>
            <div class="col-auto">
              <select class="country" id="country" name="Specialite">
                <?php foreach ($Specialites as $Specialite) {
                  if ($_POST['Specialite'] == $Specialite['Specialites']) { ?>
                <option value="<?= $Specialite['Specialites'] ?>" selected><?= $Specialite['Specialites'] ?></option>
                <?php } else { ?>
                <option value="<?= $Specialite['Specialites'] ?>"><?= $Specialite['Specialites'] ?></option>

                <?php }
                } ?>
              </select>
            </div>
          </div>
          <!-- box 2 -->
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label for="ou" class="col-form-label">Où ?</label>
            </div>
            <div class="col-auto">
              <select class="country" id="country" name="Ville">
                <?php foreach ($Villes as $Ville) {
                  if ($_GET["ville"] == $Ville) {
                ?>
                <option value="<?= $_GET['ville'] ?>" selected><?= $_GET['ville'] ?></option>
                <?php } else { ?>
                <option value="<?= $_GET['ville'] ?>"><?= $_GET['ville'] ?></option>
                <?php }
                } ?>
              </select>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">chercher</button>
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
                    <p class=" card-text"><?= $restaurant['Specialites'] ?></p>
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
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src=" ../js/script.js"></script>
  <script>
  // select search
  $(function() {
    $(".country").selectize();
  });
  // map js :
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
    '<?php echo "<div class=" . "info" . "><h3 class=" . "fs-5" . ">" . $res['Nom_Res'] . "</h3><p>" . $res['Ville'] . "</p><p>" . $res['Specialites']  . "</p> <p class=\"header\">" . $res['Cartier']  . "</p></div>"; ?>'
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