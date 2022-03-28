<?php

    function accueil(){
        //$nom = $_SESSION['profil']['nom'];
        //$idu = $_SESSION['profil']['id_nom'];
        require("Vue\accueil.tpl");
        
    }

    function jeu(){
        //$nom = $_SESSION['profil']['nom'];
        //$idu = $_SESSION['profil']['id_nom'];
        require("Vue\descartes.php");
        
    }

    function deconnexion(){
        $_SESSION = array();
        ident();
    }

    function score() {
        require("Modele\Utilisateur\utilisateur.php");
        $scores = score_bd();
        require("Vue\scores.tpl");
    }
    
    function score_GameOver() {
        $score = isset($_GET['score']) ? ($_GET['score']) : ''; 
        require("Modele\Utilisateur\utilisateur.php");
        $idu = $_SESSION['profil']['id_nom'];

        score_bd_GameOver($idu,$score);
        require("Vue\score_fin_partie.tpl");
    }

    function ident(){
        $_SESSION['email']='';
        $_SESSION['password']='';

        $email = isset($_POST['email']) ? ($_POST['email']) : '';
        $password = isset($_POST['password']) ? ($_POST['password']) : '';
        $msg = '';

        if ($email==null && $password==null)
            require("Vue\ident.tpl");
        else {
            require("Modele\Utilisateur\utilisateur.php");
            if (!verif_ident($email, $password) || !verif_ident_bd($email, $password, $resultat)) {
                $_SESSION['profil'] = array();
                
                $msg = "erreur de saisie, si vous le souhaitez vous pouvez vous "."<a href='index.php?action=inscription'>INSCRIRE</a>" ;
                $_SESSION['email']=$email;
                $_SESSION['password']=$password;

                require("Vue\ident.tpl");
                
            } else {
                $_SESSION['profil'] = $resultat[0];
                
                $url = "index.php?controle=utilisateur&action=jeu";
                header("Location:" . $url);
                //require($url);
                //$url = "accueil.php?no=$nom";
                //header ("Location:" .$url) ;    //echo ("ok, bienvenue"); 
            }
        }
}

function verif_ident($email, $password)
{
    return true; //ou false;
}

function inscription(){
    $nom = isset($_POST['nom']) ? ($_POST['nom']) : '';
    $password = isset($_POST['paswword']) ? ($_POST['password']) : '';
    $nom_ins = isset($_POST['nom_ins']) ? ($_POST['nom_ins']) : '';
    $password_ins = isset($_POST['password_ins']) ? ($_POST['password_ins']) : '';
    $email_ins = isset($_POST['email_ins']) ? ($_POST['email_ins']) : '';
    $prenom_ins = isset($_POST['prenom_ins']) ? ($_POST['prenom_ins']) : '';
    $_SESSION['nom']= isset($_SESSION['nom']) ? ($_SESSION['nom']) : '';
    $nom_i= $_SESSION['nom'];
    $_SESSION['password']= isset($_SESSION['password']) ? ($_SESSION['password']) : '';
    $password_i= $_SESSION['password'];
    $msg = '';

if (count($_POST) == 0)
    require("Vue\inscription.tpl");
    else if ($nom_ins != '' && $prenom_ins != '' && $password_ins != '' && $email_ins != '') {
        if ($nom_ins != '' && $password_ins != '' && $email_ins != '') {
            require("Modele\Utilisateur\utilisateur.php");
            inscription_mod($nom_ins, $prenom_ins, $password_ins, $email_ins);
            $msg="Votre inscription a été réalisé, veuillez vous identifier pour vous connecter";
            require("Vue\ident.tpl");
        }
    } else {
        $msg = "Veuillez renseigner toutes les informations s'il vous plaît !";
        require("Vue\inscription.tpl");
}


}
?>