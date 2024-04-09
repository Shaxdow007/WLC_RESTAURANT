<?php
require("../connexiondb.php");
if (isset($_GET["Ville"])) {
  extract($_GET);
  // Les reatau par Ville
  $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ?");
  $sql->execute([$Ville]);
  $restaurants = $sql->fetchAll();
  // Touts lesVilles
  $sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant  ");
  $sql->execute([]);
  $Villes = $sql->fetchAll();
  // Touts Specialites de ville
  $sql = $db->prepare("SELECT DISTINCT Specialites FROM restaurant WHERE Ville = ?");
  $sql->execute([$Ville]);
  $Specialites = $sql->fetchAll();
  // Touts Quartier de ville
  $sql = $db->prepare("SELECT DISTINCT Cartier FROM restaurant WHERE Ville = ?");
  $sql->execute([$Ville]);
  $Cartiers = $sql->fetchAll();
  if (isset($_POST["Specialite"])) {
    extract($_POST);
    // Les reatau par Ville et Specialite
    $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ? AND Specialites =? AND Cartier LIKE'%$Cartier%' ");
    $sql->execute([$_GET['Ville'], $Specialite]);
    $restaurants = $sql->fetchAll();
  }
} else {
  header("location:./Search.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css"
    integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
  #map {
    border-radius: 20px;
    height: 60vh;
    position: sticky;
    top: 100px;
    transition: 0.5s;
  }

  .info {
    width: 200px;
  }

  .navbar {
    top: 0px;
    z-index: 999;
  }

  .content {
    z-index: 1;
  }

  .selectize-control.single .selectize-input.input-active,
  .selectize-input {
    width: 400px;
  }

  #select {
    width: 210px !important;
    height: 35px;
    border: 1px solid #ddd;
    padding-left: 10px;
  }

  .selectize-control.single .selectize-input.input-active,
  .selectize-input {
    width: 210px;
    height: 35px;
    overflow-y: hidden;
  }

  .icon {
    width: 15px;
  }

  #select {
    width: 210px !important;
    height: 35px;
    border: 1px solid #ddd;
    padding-left: 10px;
  }

  @media screen and (max-width:769px) {
    .content {
      display: flex;
      flex-direction: column-reverse;
      align-items: center;
    }

    #map {
      display: none;
    }


    .form-content,
    .select-content {
      width: 100%;
      flex-direction: column;
      align-items: center !important;
    }

    .selectize-control.single .selectize-input.input-active,
    .selectize-input {
      width: 300px;

    }

    .button {
      width: 150px;
    }
  }
  </style>
  </style>
</head>

<body>

  <nav class="navbar bg-body-tertiary " style="width: 100%;">

    <div class="d-flex justify-content-around w-100 form-content">
      <form action="index.php?Ville=<?= $_GET['Ville'] ?>" method="post" class="form d-flex  " role="search">
        <div class="d-flex select-content align-items-end ">
          <div class="">
            Specialite:
            <select class="select" id="select" name="Specialite">
              <?php foreach ($Specialites as $Specialite) {
                if ($_POST['Specialite'] == $Specialite['Specialites']) { ?>
              <option value="<?= $Specialite['Specialites'] ?>" selected><?= $Specialite['Specialites'] ?></option>
              <?php } else { ?>
              <option value="<?= $Specialite['Specialites'] ?>"><?= $Specialite['Specialites'] ?></option>

              <?php }
              } ?>
            </select>
          </div>
          <div class="">
            Quartier:
            <select class="select" id="select" name="Cartier">
              <option value="" selected></option>
              <?php foreach ($Cartiers as $Cartier) { ?>
              <option value="<?= $Cartier['Cartier'] ?>"><?= $Cartier['Cartier'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="my-1 mx-2">
            <button class="btn btn-primary button m-auto">Search</button>
          </div>
        </div>
        <!-- box 2 -->
      </form>

      <form action="" method="get" class="form d-flex " role="search">
        <div class="d-flex select-content align-items-end">
          <div class="">
            Ville:
            <select class="select" id="select" name="Ville">
              <?php foreach ($Villes as $Ville) {
                if ($_GET["Ville"] == $Ville["Ville"]) {
              ?>
              <option value="<?= $Ville['Ville'] ?>" selected><?= $Ville['Ville'] ?></option>
              <?php } else { ?>
              <option value="<?= $Ville['Ville'] ?>"><?= $Ville['Ville'] ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="my-1 mx-2">
            <button class="btn btn-danger  button m-auto">Changer la ville</button>
          </div>
        </div>
      </form>
    </div>

  </nav>

  <!-- hero section -->

  <div class="container  container1">
    <div>
      <h1 class="fw-semibold"><span class="header">Les restos</span> <span
          class="text-danger "><?= $_GET["Ville"] ?></span></h1>
      <p class="paragraphe">Envie de nouveaux goûts ? Découvre les restaurants à proximité.</p>
    </div>
    <?php if (!empty($restaurants)) { ?>
    <div class="row h-100  content">
      <!-- restaurant -->
      <div class="col-sm-10 col-md-6 restaurant">
        <?php
          foreach ($restaurants as $restaurant) {
            $image = "data:" . $restaurant["Type_Photo"] . ";base64," . base64_encode($restaurant["Photo_Res"]);
            $place = $restaurant['Nom_Res'];
          ?>
        <!-- card start -->
        <div class="card mb-3 " style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="<?= $image ?>" class="img-fluid rounded-start" alt="<?= $restaurant['Nom_Res'] ?>">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">
                  <?= $restaurant['Nom_Res'] ?>
                </h5>
                <p class=" card-text text-danger "><?= $restaurant['Specialites'] ?></p>
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
      <div id="map" class=" col-md-6 ">
        <a href="https://www.maptiler.com"><img src="https://api.maptiler.com/resources/logo.svg"
            alt="MapTiler logo" /></a>
      </div>

    </div>
    <?php } else { ?>
    <div class="row h-100  content">
      <!-- restaurant -->
      <div class="">
        <div class="alert alert-danger" role="alert">
          <strong>Error</strong> aucun restaurant
        </div>
      </div>


    </div>
    <?php } ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

  <script>
  $(function() {
    $(".select").selectize();
  });
  window.onscroll = () => {
    var vmap = document.getElementById("map");
    if (window.scrollY >= 650) {
      vmap.style.transform = "translateY(-400px)";
      // vmap.style.position = "relative";
    } else {
      vmap.style.transform = "translateY(0)";
      vmap.style.position = "sticky";
      vmap.style.top = "100px";
    }

  }
  //starting position
  const map = L.map("map").setView(
    [
      <?php echo $restaurants[0]['C_Latitude']; ?>,
      <?php echo $restaurants[0]['C_Longitude']; ?>
    ], 12);
  var marker = L.marker(
    [
      <?php echo $restaurants[0]['C_Latitude']; ?>,
      <?php echo $restaurants[0]['C_Longitude']; ?>
    ]).addTo(map);

  <?php foreach ($restaurants as $res) : ?>
  var marker<?php echo $res['IdRes']; ?> = L.marker([<?php echo $res['C_Latitude']; ?>,
    <?php echo $res['C_Longitude']; ?>
  ]).addTo(map);
  marker<?php echo $res['IdRes']; ?>.bindPopup(
    '<?php echo "<div class=" . "info" . "><h3>" . $res['Nom_Res'] . "</h3><p>" . $res['Ville'] . "</p><p class=\"text-danger\">" . $res['Specialites'] . "</p></div>"; ?>'
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