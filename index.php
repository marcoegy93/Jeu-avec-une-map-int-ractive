<?php
session_start();

if(count($_GET)==0)
	header('Location:index.php?controle=utilisateur&action=accueil');

$controle = isset($_GET['controle']) ? $_GET['controle'] : 'utilisateur';
$action = isset($_GET['action']) ? $_GET['action'] : 'ident';

if(file_exists('Controleur/'. $controle . '.php')){
	require('Controleur/'. $controle . '.php');
	$action();
}

?>