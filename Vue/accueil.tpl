<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Accueil</title>
          <link rel="stylesheet" href="Vue/CSS/style.css">
 <link rel="stylesheet" href="Vue/CSS/bootstrap.min.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>
<style>

form {
		margin: 0 auto;
			width: 50%;
}

.form-control {
	border-radius: 0px;
}
</style>
<body>
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
		<div class="banner">
        <?php
             if(!isset($_SESSION['profil'])){
                echo("<h5 class=text>
				<p style=color: white;>Lancez-vous dans l'aventure !</p><br><br>
                <div class=wrapper>
                    <a href=index.php?controle=utilisateur&action=ident><button class=bouton2>Connexion</button></a>
                    <a href=index.php?controle=utilisateur&action=inscription><button class=bouton2>Inscription</button></a>
                </div>
			</h5>");
             }else{
                 echo("<h5 class=text>
				<p style=color: white;>Lancez-vous dans l'aventure !</p><br><br>
				<a href=index.php?controle=utilisateur&action=jeu><button class=bouton2 >Jouer</button></a>
			</h5>");
             }
        ?>
			
		</div>
	
</body></html>
