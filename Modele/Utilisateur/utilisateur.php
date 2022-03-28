<?php


function inscription_mod($nom, $prenom, $password, $email){
            require("Modele/connect.php"); 
            $sql = "insert into utilisateur(nom,prenom,password,email,score) values (:nom,:prenom,:password,:email,0)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom',$nom , PDO::PARAM_STR); 
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password , PDO::PARAM_STR); 
            $stmt->bindParam(':email', $email , PDO::PARAM_STR);
            $stmt->execute();
            $msg = 'Inscription realisé, si vous vous voulez vous connecter inscrivez votre email et votre mot de passe';
    
}

function score_bd(){
    require("Modele\connect.php");
    $sql = "select nom, prenom, score from utilisateur order by score DESC";

    $resultat = array();

    try {
        $commande = $pdo->prepare($sql);

        $bool = $commande->execute();

        if ($bool) {
            $resultat = $commande->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
        }
    }
    catch (PDOException $e) {
        $msg = utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die($msg); // On arrête tout.
    }

    return $resultat;

}
function score_bd_GameOver($id,$score){
    require("Modele\connect.php");

    $sqltest="Select score from utilisateur where id_nom =:id;"; 
    $sql = "Update utilisateur set score = :score where id_nom = :id;";

    try {
        $test = $pdo->prepare($sqltest);


        $test->bindParam(':id',$id , PDO::PARAM_INT); 
        $test->execute();
        $resultat = $test->fetch();
        
    if($resultat['score'] < $score){
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':score',$score , PDO::PARAM_INT); 
        $commande->bindParam(':id',$id , PDO::PARAM_INT); 
        $commande->execute();
        }

    }
    catch (PDOException $e) {
        $msg = utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die($msg); // On arrête tout.
    }
}

function verif_ident_bd_idu($Idu)
{
    require("Modele\connect.php");
    
    $per = $pdo->prepare("Select nom from `utilisateur` where id_nom=:identifiant ;");
    $per->bindParam(':identifiant', $Idu,PDO::PARAM_INT);
    $per->execute();
    $resultat = $per->fetch();
    $nom  = $resultat['nom'];
    if ($nom != null)
        return true;
    return false;
}

function get_identifiant($nom)
{
    require("Modele\connect.php");
    
    $per = $pdo->prepare("Select id_nom from `utilisateur` where nom=:nom ;");
    $per->bindParam(':nom', $nom,PDO::PARAM_STR);
    $per->execute();
    $resultat = $per->fetch();
    return $resultat['id_nom'];
    
}



function verif_ident_bd($email, $password, &$resultat = array())
{
    require("Modele\connect.php");
    $sql = "SELECT * FROM `utilisateur`  where email=:email and password=:pass";
    
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':email', $email);
        $commande->bindParam(':pass', $password);
        $bool = $commande->execute();
        
        if ($bool)
            $resultat = $commande->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
        
        if (count($resultat) == 0)
            return false;
        else
            return true;
    }
    
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    
    if (count($resultat) == 0)
        return false;
    else
        return true;
}
?>