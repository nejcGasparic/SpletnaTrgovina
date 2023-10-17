<?php
    session_start();
    unset($_SESSION["adminFlag"]);
    unset($_SESSION["newSellerPassword"]);
    if($_SESSION["loggedin"] == true){
       echo "Dela ";
       echo $_SESSION["username"]. " ";
       echo $_SESSION["id"];
    }
    else{
        echo "Ni prijavljenih oseb";
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Predračun</title>
        <link rel="stylesheet" type="text/css" href="/netbeans/spletna-trgovina/static/css/style.css?version=<?= time() ?>">
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>        
    </head>
    <body>
        <section class="h-100" style="background-color: #eee;">
          <div class="container h-100 py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
              <div class="col-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h3 class="fw-normal mb-0 text-black">Nakupovalna košarica</h3>

                </div>
                <!-- comment -->
                <?php foreach ($cart as $item): ?>                
                    <div class="card rounded-3 mb-4">
                      <div class="card-body p-4">
                        <div class="row d-flex justify-content-between align-items-center">
                          <div class="col-md-3 col-lg-3 col-xl-3">
                            <p class="lead fw-normal mb-2"><?=$item["naziv_artikla"] ?></p>
                          </div>
                          <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                              <p class="lead fw-normal mb-2">Količina <br> <?= $item["kolicina"]?></p>
                          </div>
                          <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                              <p class="lead fw-normal mb-2">Cena <br> <?= $item["cena_artikla"]?> €</p>
                          </div>
                        </div>
                      </div>
                    </div>
                <!-- comment -->
                <?php endforeach; ?>
                <div class="card mb-4">
                  <div class="card-body p-4 d-flex flex-row">
                    <div class="form-outline flex-fill">
                      <p class="lead fw-normal mb-2">SKUPAJ: <?= number_format($total, 2) ?> EUR </p>
                    </div>
                  </div>
                </div>                
                <div class="card" >
                  <div class="card-body">
                      <form action="<?= BASE_URL . $_SESSION["roleName"] . "purchase" ?>" method="post">
                        <button type="submit" class="btn btn-secondary btn-block btn-lg">Potrdi naročilo</button>
                      </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>        
    </body>
</html>
