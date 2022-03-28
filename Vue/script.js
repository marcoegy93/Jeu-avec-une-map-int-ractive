// ***** Déclaration de variables ***** //
// variables du jeu
var lat;
var lng;
var zoomLock = false;
var listeMarqueurs = [];
var routeLayer;
var map;
var monMarqueur;
var monPopup = L.popup({keepInView:true,closeButton:false}).setContent(
    "<h3>Votre restaurant !</h3>" +
    "<center><img src='Vue/images/restoicon.png' width='50' height='50'></center>"
);
var homeIcon = L.icon({
    iconUrl: "Vue/images/homeicon.png",
    iconSize: [40, 40],
    iconAnchor: [20, 20],
    popupAnchor: [0, -20]
});
var restoIcon = L.icon({
    iconUrl: "Vue/images/restoicon.png",
    iconSize: [40, 40],
    iconAnchor: [20, 20],
    popupAnchor: [0, -20]
});
var gasIcon = L.icon({
    iconUrl: "Vue/images/gasicon.png",
    iconSize: [40, 40],
    iconAnchor: [20, 20],
    popupAnchor: [0, -20]
});
var essence = 300;
var max_essence = 300;
var ctx;
var livreurDispo=true;
var listeIntervals = Array(3);
var argent;
// variables du timer
let progressBar;
let indicator;
let pointer;
let length = Math.PI * 2 * 100;
let timeLeft;
let wholeTime = 5*60; // manage this to set the whole time
let isStarted = true;
var displayOutput;
var jouer = document.getElementById('jouer');
// ***** Lancement du script ***** //


window.onload = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            init();
        }, showError);
        
    } else {
        $('#map').html("<p>Votre navigateur ne prend pas la géolocalisation en charge</p>");
    }

    progressBar = document.querySelector('.e-c-progress');
    indicator = document.getElementById('e-indicator');
    pointer = document.getElementById('e-pointer');
    displayOutput = document.querySelector('.display-remain-time');
    progressBar.style.strokeDasharray = length;
    listeIntervals[1]=setInterval(newMarker,5000);
    update(wholeTime,wholeTime); //refreshes progress bar
    displayTimeLeft(wholeTime);
    timer(wholeTime);
}

//     progressBar = document.querySelector('.e-c-progress');
//     indicator = document.getElementById('e-indicator');
//     pointer = document.getElementById('e-pointer');
//     displayOutput = document.querySelector('.display-remain-time');
//     progressBar.style.strokeDasharray = length;
//      listeIntervals[1]=setInterval(newMarker,5000);
//     update(wholeTime,wholeTime); //refreshes progress bar
//     displayTimeLeft(wholeTime);
//     timer(wholeTime);
// }

// ***** Fonctions du jeu ***** //
function gameover() {
    flushMap();
    clearInterval(listeIntervals[0]); // màj essence
    clearInterval(listeIntervals[1]); // new marker
    clearInterval(listeIntervals[2]); // timer
    //let url = "index.php?controle=utilisateur&action=score_GameOver";
    //let param = new URLSearchParams(url.search);
    //param.set('score', argent);
    //window.location.href = url;
    window.location.href = "index.php?controle=utilisateur&action=score_GameOver&score="+argent;
    
}

function majEssence() {
    essence -= 5;
    //ctx.fillRect(essence, 0, 50, max_essence); 
    $("#essence").html("Essence : "+essence+" litres");
    if(essence <= 0) {
        gameover();
    }
}

// génère un point aléatoire dans un rayon de x mètres autour de l'origine
function getRandomPos(origine,rayon) {
    var cercle = L.circle(origine,rayon).addTo(map);
        bounds = cercle.getBounds();
        sudOuest = bounds.getSouthWest();
	    nordEst = bounds.getNorthEast();
	    deltaLng = nordEst.lng - sudOuest.lng;
	    deltaLat = nordEst.lat - sudOuest.lat;
    map.removeLayer(cercle);
    return [sudOuest.lat + deltaLat * Math.random(),sudOuest.lng + deltaLng * Math.random()];
}

function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        lat = 48.84196684413519;
        lng = 2.2676688129941303;
        init();
        break;
      case error.POSITION_UNAVAILABLE:
        $('#map').html("Votre géolocalisation est introuvable");
        break;
      case error.TIMEOUT:
        $('#map').html("La demande de géolocalisatio a pris trop de temps à répondre");
        break;
      case error.UNKNOWN_ERROR:
        $('#map').html("Une erreur inconnue est survenue");
        break;
    }
}

function coordGeoJSON(latlng,precision) { 
    return '[' +
        L.Util.formatNum(latlng.lng, precision) + ',' +
        L.Util.formatNum(latlng.lat, precision) + ']';
}

async function envoyerLivreur(origine, destination, marker) {
    if(!livreurDispo) {
        alert("Livreur indisponible !");
    } else if (marker.options.icon == gasIcon && argent < 30) {
        alert("Vous n'avez pas assez d'argent pour faire le plein !");
    } else {
        livreurDispo=false;
        listeIntervals[0]=setInterval(majEssence,1000);
        let tmpTempsTrajet=await getTempsTrajet(origine,destination);
        $("#statutLivreur").html("Livreur indisponible (temps de trajet : "+
        Math.floor(tmpTempsTrajet/1000)+" secondes)");
        setTimeout(function(){
            $("#statutLivreur").html("Livreur disponible");
            if(marker.options.icon==homeIcon) {
                argent+=Math.floor(tmpTempsTrajet/1000);
                $("#argent").html("Vous avez "+argent+"€");
            } else {
                essence=max_essence;
                argent-=30;
                $("#essence").html("Essence : "+essence+" litres");
                $("#argent").html("Vous avez "+argent+"€");
            }
            map.removeLayer(marker);
            map.removeLayer(routeLayer);
            clearInterval(listeIntervals[0]);
            livreurDispo=true;
        },tmpTempsTrajet);
    }
}

function afficherRoute(origine, destination) {
    $.ajax({
        url:"https://api.openrouteservice.org/v2/directions/driving-car",
        data:{
            api_key:"5b3ce3597851110001cf6248af3f8c894b6f40c6a0cac499f8856298",
            start:origine.lng+","+origine.lat,
            end:destination.lng+","+destination.lat
        },
        success:function(retour){
            if(routeLayer != undefined) {
                map.removeLayer(routeLayer)
            }
            routeLayer = L.geoJson(retour).addTo(map).bindPopup(
                Math.floor(retour.features[0].properties.summary.duration/100) + 
                " secondes de trajet");
        },
        error:function(){
            alert("Erreur api ORS");
        }
    });
}

function getTempsTrajet(origine, destination) {
    let tmpTempsTrajet;
    $.ajax({
        url:"https://api.openrouteservice.org/v2/directions/driving-car",
        data:{
            api_key:"5b3ce3597851110001cf6248af3f8c894b6f40c6a0cac499f8856298",
            start:origine.lng+","+origine.lat,
            end:destination.lng+","+destination.lat
        },
        async:false,
        success:function(retour){
            tmpTempsTrajet = (retour.features[0].properties.summary.duration)*10; //retourne tps de trajet en millisecondes
        },
        error:function(){
            alert("Erreur api ORS");
        }
    });
    return tmpTempsTrajet;
}

function newMarker() {
    let randIcon = (Math.random() < 0.15 ? gasIcon : homeIcon)
    var tabCoord = getRandomPos(monMarqueur.getLatLng(),5000);
    var marqTmp=L.marker(tabCoord,{icon:randIcon});
    marqTmp.addTo(map);
    if(randIcon == gasIcon) {
        marqTmp.bindPopup("Station service : 30€ le plein");
    } else {
        $.ajax({
            url:"https://nominatim.openstreetmap.org/reverse?format=json&lat="+tabCoord[0]+"&lon="+tabCoord[1],
            data:{},
            async:false,
            success:function(retour){
                marqTmp.bindPopup("Client en attente de livraison<br>Adresse : "+retour.address.road+", "+retour.address.postcode+", "+retour.address.state);
            },
            error:function(){
                alert("Erreur api ORS");
            }
        });
    }
    marqTmp.on('click',function(e){
        afficherRoute(e.latlng,monMarqueur.getLatLng());
    });
    marqTmp.on('dblclick',function(e){
        envoyerLivreur(e.latlng,monMarqueur.getLatLng(),marqTmp);
    });
    listeMarqueurs.push(marqTmp);
}

function flushMap() {
    for (i in listeMarqueurs) {
		listeMarqueurs[i].removeFrom(map);
	}
    listeMarqueurs=[];
}

function init() { 
    argent=0;
    map = L.map('map').setView([lat, lng],15);
    L.tileLayer('https://stamen-tiles.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', {attribution: 'Des Cartes - Fevrier 2022'}).addTo(map);
    map.attributionControl.setPrefix('');
    monMarqueur = L.marker([lat, lng],{icon:restoIcon}).addTo(map).bindPopup(monPopup);

    map.on("zoomstart", function(e) {
        if(zoomLock){
          throw 'zoom disabled';
        }
    });
}

// ***** Fonctions du timer ***** //
function update(value, timePercent) {
	var offset = - length - length * value / (timePercent);
	progressBar.style.strokeDashoffset = offset; 
	pointer.style.transform = `rotate(${360 * value / (timePercent)}deg)`; 
}

function changeWholeTime(seconds){
  if ((wholeTime + seconds) > 0){
    wholeTime += seconds;
    update(wholeTime,wholeTime);
  }
}

function timer (seconds){ //counts time, takes seconds
  let remainTime = Date.now() + (seconds * 1000);
  displayTimeLeft(seconds);
  
  listeIntervals[2] = setInterval(function(){
    timeLeft = Math.round((remainTime - Date.now()) / 1000);
    if(timeLeft < 0){
      isStarted = false;
      gameover();
      return ;
    }
    displayTimeLeft(timeLeft);
  }, 1000);
}

function displayTimeLeft (timeLeft) { //displays time on the input
  let minutes = Math.floor(timeLeft / 60);
  let seconds = timeLeft % 60;
  let displayString = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
  displayOutput.textContent = displayString;
  update(timeLeft, wholeTime);
}

