<?php
	$reqdroit = $DB->query('Select droit from user where id = '.$_SESSION['id'].'');
	$reqdroit = $reqdroit->fetch();
if(!isset($_SESSION['id']) or $reqdroit['droit'] != "admin"){
	header('Location: index');
	exit;
}
?>