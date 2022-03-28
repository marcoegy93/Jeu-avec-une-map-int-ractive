<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="Vue/CSS/style.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="Vue/CSS/bootstrap.min.css">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>

<body>
<style>
form {
		margin: 0 auto;
			width: 50%;
}

.bouton {
  margin: 0 auto;

  background-color: black;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: block;
  font-size: 16px;
}

.form-control {
	border-radius: 0px;
}
</style>
<nav class="navbar">
            <div class="content">
                <div class="logo"><a href="index.html"><img src="Vue/images/logo.png" id="logo"></a><a href="index.php?controle=utilisateur&action=accueil" id="text_logo">DELIVERATOR</a></div>
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
		<br><br><br><br><br><br><br>
<h3 style="text-align: center"> FORMULAIRE D'INSCRIPTION </h3> 
<form class="form" action="index.php?controle=utilisateur&action=inscription" method="post">
	<label>Nom</label>
    <input 	name="nom_ins" 	class="form-control" type="text" value= "<?php echo  $_SESSION['nom'];?>" placeholder="Nom"><br/>
	<label>Prénom</label>
    <input  name="prenom_ins"  class="form-control" type="text"  value= "<?php echo $prenom_ins;?>" placeholder="Prénom"><br/> 
	<label>Email</label>
	<input 	name="email_ins" 	class="form-control" type="email" value= "<?php echo $email_ins;?>" placeholder="Email"><br/>
	<label>Mot de passe</label>
	<input 	name="password_ins" 	class="form-control" type="text" value= "<?php echo $_SESSION['password'];?>" placeholder="Mot de passe"><br/>
	<div><p style="text-align: center;"><?php echo $msg; ?></p></div>	
	<input type= "submit" class="bouton" value="Inscription">
	</form>
 
</body></html>