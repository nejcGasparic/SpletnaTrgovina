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
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>"/>
<meta charset="UTF-8" />
<title>Nastavitve strank</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand font-weight-bold text-white" href="<?= BASE_URL . $_SESSION["roleName"] . "store" ?>">E-TRGOVINA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link px-4" href="<?= BASE_URL . $_SESSION["roleName"] . "store" ?>">Izdelki</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" id="registracija" href="<?= BASE_URL . "register" ?>">Registracija</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="prijava" href="<?= BASE_URL . "login" ?>">Prijava</a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-none" id="mojaNarocila" href="#">Moja naročila</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-none" id="nastavitve" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-gear-fill"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="right: 0; left: auto;">
              <a class="dropdown-item" id="nastavitveRacuna" href="<?=BASE_URL . $_SESSION["roleName"] . "user?id=" . $_SESSION["id"]?>">Nastavitve računa</a>
              <a class="dropdown-item d-none" id="nastavitveProdajalcev" href="#">Prodajalci</a>
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
    <input type="hidden" value="<?=$_SESSION["loggedin"]?>" id="loggedFlag">
    <input type="hidden" value="<?=$_SESSION["userRole"]?>" id="userRole">
    <script src="/netbeans/spletna-trgovina/script/user.js?version=<?= time() ?>"></script>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold pt-4 mb-2">
            Stranke
        </h4>
        <div id="accordion">
            <?php foreach ($customers as $customer): ?>
                <div class="card">
                  <div class="card-header" id="<?= $customer["ime_uporabnika"]?>">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#<?= $customer["id_uporabnika"]?>" aria-expanded="false" aria-controls="<?= $customer["id_uporabnika"]?>">
                        <?= $customer["ime_uporabnika"] ?>
                      </button>
                    </h5>
                  </div>

                  <div id="<?= $customer["id_uporabnika"]?>" class="collapse" aria-labelledby="<?= $customer["ime_uporabnika"]?>" data-parent="#accordion">
                    <div class="card-body">
                    <form action="<?= BASE_URL . "seller/user" ?>" method="post">
                        <input type="hidden" name="id" value="<?= $customer["id_uporabnika"]?>"/>
                        <h4 class="font-weight-bold pt-4 mb-2">
                          Nastavitve računa
                        </h4>

                        <div class="card overflow-hidden">
                          <div class="row no-gutters row-bordered row-border-light">
                            </div>
                            <div class="col-md-9">
                              <div class="tab-content">
                                <div class="tab-pane fade active show" id="account-general">

                                  <hr class="border-light m-0">

                                  <div class="card-body">
                                        <div class="form-group">
                                          <label class="form-label">Ime uporabnika</label>
                                          <input type="text" name="name" class="form-control mb-1" value="<?= $customer["ime_uporabnika"]?>">
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label">Priimek uporabnika</label>
                                          <input type="text" name="surname" class="form-control" value="<?= $customer["priimek_uporabnika"]?>">
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label">E-mail</label>
                                          <input type="email" name="email" class="form-control mb-1" value="<?= $customer["elektronski_naslov"]?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Trenutno geslo</label>
                                            <input type="password" name="currentPassword" class="form-control"value="">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Novo geslo</label>
                                            <input type="password" name="newPassword" class="form-control" value="">
                                        </div>                          
                                  </div>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="text mt-2">
                                <button type="submit" class="btn btn-secondary">Shrani spremembe</button>&nbsp;
                            </div>
                        </form>
                        <?php
                            if($customer["aktiven"] == 1){
                            ?>
                            <form action="<?= BASE_URL . "deactivate" ?>" method="post">
                                <input type="hidden" name="id" value="<?= $customer["id_uporabnika"]?>"/>
                                <button class="btn btn-secondary">Deaktiviraj</button>
                            </form>
                        <?php
                            }else{
                            ?>
                            <form action="<?= BASE_URL . "activate" ?>" method="post">
                                <input type="hidden" name="id" value="<?= $customer["id_uporabnika"]?>"/>
                                <button class="btn btn-secondary">Aktiviraj</button>
                            </form>
                        <?php
                            }
                        ?>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="btn btn-secondary" style="margin-top: 20px" href="<?= BASE_URL . $_SESSION["roleName"] . "createUser" ?>">
            Ustvari novo stranko</a>
    </div>
        <!-- Modal -->
        <div class="modal fade" id="modalSuccessRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=$_SESSION["messageHeading"]?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p><?=nl2br($_SESSION["messageToUser"])?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
              </div>
            </div>
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