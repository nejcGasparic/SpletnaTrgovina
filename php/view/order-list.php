<?php
    require_once("ViewHelper.php");
    session_start();
    //da dovoli spremembe sellerjev
    $_SESSION["adminFlag"] = true;
    unset($_SESSION["newSellerPassword"]);
    if($_SESSION["loggedin"] == true){
        echo "Dela ";
        echo $_SESSION["id"];
    }
    else{
        echo "Ni prijavljenih oseb";
        ViewHelper::redirect(BASE_URL . "store");
    }
    /*
    if($_SESSION["roleName"] != "admin/"){
        ViewHelper::redirect(BASE_URL . "store");
    }
     * */
    $a = ["1" => "Neobdelano", "2" => "Potrjeno", "3" => "Preklicano", "4" => "Stornirano"];
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>"/>
<meta charset="UTF-8" />
<title>Moja naročila</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand font-weight-bold text-white" href="<?= BASE_URL . $_SESSION["roleName"] ."store" ?>">E-TRGOVINA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link px-4" href="<?= BASE_URL . $_SESSION["roleName"] ."store" ?>">Izdelki</a>
          </li>
        </ul>
        <li class="nav-item" style="list-style: none">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Išči" aria-label="Search">
                <button class="btn btn-outline-secondary" type="submit">Išči</button>
            </form>
        </li>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" id="registracija" href="<?= BASE_URL . "register" ?>">Registracija</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="prijava" href="<?= BASE_URL . "login" ?>">Prijava</a>
          </li>
          <li class="nav-item">
              <a class="nav-link d-none" id="mojaKosarica" href="javascript:showCart()">Moja košarica</a>
          </li>          
          <li class="nav-item">
            <a class="nav-link d-none" id="mojaNarocila" href="<?= BASE_URL . $_SESSION["roleName"] . "orders" ?>">Moja naročila</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-none" id="nastavitve" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-gear-fill"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="right: 0; left: auto;">
              <a class="dropdown-item" id="nastavitveRacuna" href="<?=BASE_URL . $_SESSION["roleName"] . "user?id=" . $_SESSION["id"]?>">Nastavitve računa</a>
              <a class="dropdown-item d-none" id="nastavitveProdajalcev" href="<?=BASE_URL . $_SESSION["roleName"] . "sellerSettings" ?>">Prodajalci</a>
              <a class="dropdown-item d-none" id="nastavitveNarocil" href="#">Naročila</a>
              <a class="dropdown-item d-none" id="nastavitveArtiklov" href="<?=BASE_URL . $_SESSION["roleName"] . "itemSettings"?>">Artikli</a>
              <a class="dropdown-item d-none" id="nastavitveStranke" href="<?=BASE_URL . $_SESSION["roleName"] . "customerSettings"?>">Stranke</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link d-none" id="odjava" href="<?= BASE_URL . "logout"?>">Odjava</a>
          </li>
        </ul>
      </div>
    </nav>
    <input type="hidden" value="<?=$_SESSION["loggedin"]?>" id="loggedFlag">
    <input type="hidden" value="<?=$_SESSION["userRole"]?>" id="userRole">
    <script src="/netbeans/spletna-trgovina/script/user.js?version=<?= time() ?>"></script>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold pt-4 mb-2">
            Moja naročila
        </h4>
        <div id="accordion">
            <?php foreach ($orders as $order): ?>
                <div class="card">
                  <div class="card-header" id="<?= $order["id_naročila"]."narocilo"?>">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#<?= $order["id_naročila"]?>" aria-expanded="false" aria-controls="<?= $order["id_naročila"]?>">
                        <?= "Naročilo #". $order["id_naročila"]  ?>
                      </button>
                    </h5>
                  </div>

                  <div id="<?= $order["id_naročila"]?>" class="collapse" aria-labelledby="<?= $order["id_naročila"]."narocilo"?>" data-parent="#accordion">
                    <div class="card-body">
                        <h4 class="font-weight-bold pt-4 mb-2">
                          Postavke naročila
                        </h4>

                        <div class="card overflow-hidden">
                          <div class="row no-gutters row-bordered row-border-light">
                            </div>
                            <div class="col-md-9">
                              <div class="tab-content">
                                <div class="tab-pane fade active show" id="account-general">

                                  <hr class="border-light m-0">

                                  <div class="card-body">
                                            <p class="lead fw-normal mb-2">Skupna cena: <?= $order["cena"]?>€</p>
                                            <p class="lead fw-normal mb-2">Status naročila: <?= $a[$order["Status_id_statusa"]] ?></p>
                                            <h5>Artikli naročila</h5>
                                            <ul>
                                            <?php foreach ($order["items"] as $item): ?>
                                                <li>
                                                    <p>[<?= $item["naziv_artikla"]?>]     Količina:<b><?= $item["količina"]?></b>     Cena artikla:<b><?= $item["cena_artikla"]?></b></p>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                  </div>
                                </div>
                                </div>
                            </div>
                            </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script>
    /*
    var message = <?= isset($_SESSION["messageToUser"]) ? json_encode($_SESSION["messageToUser"]) : '""' ?>;
    var myModal = $("#modalSuccessRegister");
    if(message){
        console.log(message);
        myModal.modal("show");
    }
    else{
        console.log("Ni nastavljena");
    }
    */
</script>
</body>