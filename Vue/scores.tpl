<html>
<head>
<meta charset="utf-8">
  <title>Scores</title>
 <link rel="stylesheet" href="Vue/CSS/style.css">
 <link rel="stylesheet" href="Vue/CSS/bootstrap.min.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>
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
        </nav><br><br><br><br><br>
<h1 style="text-align: center">Classement des scores</h1>
			
			<?php
			echo "<table class='table'>";
			
			echo ('<tr><th> NOM </th> <th> PRENOM </th> <th> SCORE </th></tr>'); 	
			foreach ($scores as $s) {
				echo "<tr class='contact'>";
				echo ("<td>" . utf8_encode($s['nom']) . "</td>"); 
				echo ("<td>" . utf8_encode($s['prenom']) . "</td>"); 
				echo ("<td>" . utf8_encode($s['score']) . "</td>"); 
				echo "</tr>\n";
				
			}
			echo "</table>";

            ?>
</body>
</html>