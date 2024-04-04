<?php
require("./connexiondb.php");
if (isset($_POST['done'])) {
    extract($_POST);
    $sql = $db->prepare("SELECT * FROM Admin WHERE Email = ? AND Pass = ?");
    $sql->execute([$Email, $Pass]);
    $user = $sql->fetch();
    if (!empty($user)) {
        session_start();
        $_SESSION["Data"] = $user;
        header("location:index.php");
    } else {
        $error = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>


<body class="">
  <nav class="w-100 d-flex justify-content-between align-items-center bg-danger" style="padding: 5px 0;">
    <a href="https://www.eat.ma/" class="link-dark px-2 fs-4"><img class="w-50" src="./images/eatLogo.png"
        alt="eat"></a>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-center bg-light"
        style="height: 100vh;">
        <p class="fs-3 text-danger ">Eat.ma</p>
        <p class="text-dark fs-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta, quod.</p>
      </div>
      <div class="col-sm-12 col-md-6 form-body d-flex justify-content-center align-items-center m-auto "
        style="height: 100vh;">

        <div class="d-flex justify-content-center align-items-center ">

          <div class="form-holder ">
            <div class="form-content m-auto">
              <div class="form-items ">
                <h3 class="my-3">Login</h3>
                <p class="">
                  Remplissez les données ci-dessous.</p>
                <?php
                                if (isset($error)) {
                                ?><p class="alert alert-danger ">incorrect email or password</p><?php } ?>
                <form action="#" method="post" class="requires-validation " enctype="multipart/form-data">
                  <div class="col-md-12">
                    <input class="form-control my-3" type="email" name="Email" placeholder="Email" required>
                  </div>

                  <div class="col-md-12">
                    <input class="form-control my-3" type="password" name="Pass" placeholder="Mot de pass" required>
                  </div>
                  <div class="form-button mt-3">
                    <button id="submit" type="submit" class="btn btn-danger" name="done">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>



  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>