<html>
<head>
<link rel="stylesheet" href="Vue/CSS/style.css">
 <link rel="stylesheet" href="Vue/CSS/bootstrap.min.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="Vue/script.js"></script>

</head>
<body>
<style>
  html, body {
     padding: 0;
     margin: 0;
     height: 100%;
  }

  .wrapper2 {
     padding: 0;
     margin: 0;
     height: 90%;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
  }
  
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    text-align:center;
  }

  #c1 {
    background-color: #7FFF00;
  }

  .container {
    position: relative;
    top: 30px;
    width: 300px;
    margin: 0 auto;
  }

  .setters {
    position: absolute;
    left: 85px;
    top: 75px;
  }

  .minutes-set {
    float: left;
    margin-right: 28px;
  }

  .seconds-set { float: right; }

  .controlls {
    position: absolute;
    left: 75px;
    top: 105px;
    text-align: center;
  }

  .display-remain-time {
    font-family: 'Roboto';
    font-weight: 100;
    font-size: 65px;
    color: #F7958E;
  }

  #pause {
    outline: none;
    background: transparent;
    border: none;
    margin-top: 10px;
    width: 50px;
    height: 50px;
    position: relative;
  }

  .play::before {
    display: block;
    content: "";
    position: absolute;
    top: 8px;
    left: 16px;
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
    border-left: 22px solid #F7958E;
  }

  .pause::after {
    content: "";
    position: absolute;
    top: 8px;
    left: 12px;
    width: 15px;
    height: 30px;
    background-color: transparent;
    border-radius: 1px;
    border: 5px solid #F7958E;
    border-top: none;
    border-bottom: none;
  }

  #pause:hover { opacity: 0.8; }

  .e-c-base {
    fill: none;
    stroke: #B6B6B6;
    stroke-width: 4px
  }

  .e-c-progress {
    fill: none;
    stroke: #F7958E;
    stroke-width: 4px;
    transition: stroke-dashoffset 0.7s;
  }

  .e-c-pointer {
    fill: #FFF;
    stroke: #F7958E;
    stroke-width: 2px;
  }

  #e-pointer { transition: transform 0.7s; }
  h1 { margin-top:150px; text-align:center;}
  body { background-color:#f7f7f7;}

</style>
<nav class="navbar">
            <div class="content">
                <div class="logo"><a href="index.php?controle=utilisateur&action=accueil"><img src="Vue/images/logo.png" id="logo"></a><a href="index.php?controle=utilisateur&action=accueil" id="text_logo">DELIVERATOR</a></div>
                <?php 
                    if(!isset($_SESSION['profil'])){
                        echo("<ul class=menu-list>
                            <li><a href=index.php?controle=utilisateur&action=ident>Connexion</a></li>
                            <li><a href=index.php?controle=utilisateur&action=inscription>Inscription</a></li>   
                            </ul>");
                    }else{
                        echo("<ul class=menu-list>
                            <li><a href=index.php?controle=utilisateur&action=jeu>Jouer</a></li>
                            <li><a href=index.php?controle=utilisateur&action=score>Scores</a></li>
                            <li><a href=index.php?controle=utilisateur&action=deconnexion>Deconnexion</a></li>      
                        </ul>");
                    }
                ?>
				
			
                <div class="burger">
                    <span></span>
                </div>
        </nav>
        <br><br><br>
        <div class="wrapper2">
            <div id="map"></div>
                <div id="header">
                    
                    <div>
                        <p id="essence" style='text-align:center'>Essence : 300 litres</p>
                        <p id="statutLivreur" style='text-align:center'>Livreur disponible</p>
                        <p id="argent" style='text-align:center'>Vous avez 0€</p>
                    </div>
                    <div class="container">
                        <div class="circle"> <svg width="300" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(110,110)">
                            <circle r="100" class="e-c-base"/>
                            <g transform="rotate(-90)">
                                <circle r="100" class="e-c-progress"/>
                                <g id="e-pointer">
                                <circle cx="100" cy="0" r="8" class="e-c-pointer"/>
                                </g>
                            </g>
                            </g>
                            </svg> 
                        </div>
                        <div class="controlls">
                            <div class="display-remain-time">05:00</div>
                        </div>
                    </div>
                </div>

        </div>

</body>
</html>