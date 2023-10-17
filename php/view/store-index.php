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

<!DOCTYPE html>
<html>
    <link rel="stylesheet" type="text/css" href="/netbeans/spletna-trgovina/static/css/style.css?version=<?= time() ?>">
    <meta charset="UTF-8" />
    <title>Trgovina</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
              <a class="dropdown-item d-none" id="nastavitveNarocil" href="<?=BASE_URL . $_SESSION["roleName"] . "orders" ?>">Naročila</a>
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
    <div class="card-group" style="margin-top: 30px; width: 70%">
        <?php foreach ($items as $item): ?>
            <div class="col-sm-6" style="margin-bottom: 15px">
                <div class="card">
                    <h5 class="card-header"><b><?= $item["naziv_artikla"] ?></b></h5>                    
                    <div class="card-body">
                    </div>
                    <div class="card-footer">
                        <form action="<?= BASE_URL . $_SESSION["roleName"] ."store/add-to-cart" ?>" method="post">
                            <input type="hidden" name="id" value="<?= $item["id_artikla"] ?>"/>
                            <button type="submit" class="btn btn-secondary shopping-btn" style="display: inline-block; margin-right: 15px">V košarico</button>
                            <p class="card-text" style="display: inline-block"><?= $item["cena_artikla"]?> €</p>                     
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div  id="cart" hidden="hidden">
        <h3><b>Košarica</b></h3>
        <?php foreach ($cart as $item): ?>

            <form action="<?= BASE_URL . $_SESSION["roleName"] . "store/update-cart" ?>" method="post">
                <input type="hidden" name="id" value="<?= $item["id_artikla"] ?>" />
                <input type="number" name="quantity" value="<?= $item["kolicina"] ?>" class="update-cart" />
                &times; <?= $item["naziv_artikla"] ?> 
                <button class="btn btn-light">Posodobi</button> 
                <br>
            </form>
        <?php endforeach; ?>
        <p>Skupaj: <b><?= number_format($total, 2) ?> EUR</b></p>
        <div style="float:left;">
        <form action="<?= BASE_URL . $_SESSION["roleName"]. "store/purge-cart" ?>" method="post">
            <button class="btn btn-secondary">Izprazni košarico</button>
        </form>
        </div>
        <div style="float:right;">
        <form action="<?= BASE_URL . $_SESSION["roleName"]. "invoice" ?>" method="post">
            <button class="btn btn-primary">Zaključi nakup</button>
        </form>
        </div>
    </div>    
    <input type="hidden" value="<?=$_SESSION["loggedin"]?>" id="loggedFlag">
    <input type="hidden" value="<?=$_SESSION["userRole"]?>" id="userRole">
    <script src="/netbeans/spletna-trgovina/script/user.js?version=<?= time() ?>"></script>
</html>