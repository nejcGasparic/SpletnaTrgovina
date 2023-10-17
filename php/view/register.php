<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Library</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand font-weight-bold text-white" href="<?= BASE_URL . "" ?>">E-TRGOVINA</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link px-4" href="<?= BASE_URL . "store" ?>">Izdelki</a>
      </li>
    </ul>
  </div>
</nav>
<body style="background-color: gainsboro">
    <section class="vh-100 bg-image" style="padding-top: 50px;">
      <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body p-5">
                  <h2 class="text-uppercase text-center mb-5">Ustvari račun</h2>

                  <form action="<?= BASE_URL . "register" ?>" method="post">
                    <div class="form-outline mb-4">
                      <label class="form-label">Ime</label>
                      <input type="text" name="name" class="form-control form-control-lg" value="<?=$name?>"/>
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label">Priimek</label>
                      <input type="text" name="surname" class="form-control form-control-lg" value="<?=$surname?>" />
                    </div>  

                    <div class="form-outline mb-4">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control form-control-lg" value="<?=$email?>" />
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label">Geslo</label>
                      <input type="password" name="password" class="form-control form-control-lg" value="<?=$password?>" />
                      <input type="hidden" name="role" value="3"/>
                      <p class="small text-muted mt-2">Geslo mora biti dolgo vsaj 6 znakov in ne več kot 25</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit"
                        class="btn btn-secondary btn-block btn-lg gradient-custom-4 text-body">Registriraj se</button>
                    </div>

                    <p class="text-center text-muted mt-5 mb-0">Že imaš račun? <a href="<?= BASE_URL . "login" ?>"
                        class="fw-bold text-body"><u>Prijavi se tukaj!</u></a></p>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</body>
<!-- Modal -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Napaka</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?=$errorMessage?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
      </div>
    </div>
  </div>
</div>
<script>
    var errorMessage = <?= isset($errorMessage) ? json_encode($errorMessage) : '""' ?>;
    var myModal = $("#modalError");
    if(errorMessage){
        console.log(errorMessage);
        myModal.modal("show");
    }
    else{
        console.log("Ni nastavljena");
    }
</script>