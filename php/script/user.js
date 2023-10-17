var flagForLoggedUser = document.getElementById("loggedFlag").value;
console.log(flagForLoggedUser);
$('.shopping-btn').attr('disabled',true);
if(flagForLoggedUser){
    var userRole = document.getElementById("userRole").value;
    console.log(userRole);
    var login = document.getElementById("prijava");
    login.classList.add("d-none");
       
    var register = document.getElementById("registracija");
    register.classList.add("d-none");
       
    var logout = document.getElementById("odjava");
    logout.classList.remove("d-none");
       
    var settings = document.getElementById("nastavitve");
    settings.classList.remove("d-none");
       
    //prijavljen uporabnik je ADMINISTRATOR
    if(userRole == 1){
        var sellerSettings = document.getElementById("nastavitveProdajalcev");
        sellerSettings.classList.remove("d-none");
       }
    //prijavljen uporabnik je PRODAJALEC
    else if(userRole == 2){
        var orderSettings = document.getElementById("nastavitveNarocil");
        orderSettings.classList.remove("d-none");
           
        var itemSettings = document.getElementById("nastavitveArtiklov");
        itemSettings.classList.remove("d-none");
           
        var customerSettings = document.getElementById("nastavitveStranke");
        customerSettings.classList.remove("d-none");
    }
    //prijavljen uporabnik je STRANKA 
    else if(userRole == 3){
        $('.shopping-btn').attr('disabled',false);
        var myOrders = document.getElementById("mojaNarocila");
        myOrders.classList.remove("d-none");
        let cart = document.getElementById("cart");
        cart.removeAttribute("hidden");
        var myCart = document.getElementById("mojaKosarica");
        myCart.classList.remove("d-none");
    }
}

function showCart(){
    //console.log("Hello Cart");
    let cart = document.getElementById("cart");
    let hidden = cart.getAttribute("hidden");
    
    if(hidden){
        cart.removeAttribute("hidden");
    }else{
        cart.setAttribute("hidden","hidden");
    }
}