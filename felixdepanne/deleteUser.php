<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces

$id = (int)$_GET['id'];

//Envoi mail
$Email = $DB->query("SELECT email from user where id=$id");
$Email = $Email->fetch();

$destinataire = $Email['email'];
// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
$expediteur = 'felixdepanne@gmail.com';
$copie = 'felixdepanne@gmail.com';
$copie_cachee = 'felixdepanne@gmail.com';
$objet = 'Suppression de compte'; // Objet du message
$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
$headers .= 'From: "Support - Felixdepanne"<'.$expediteur.'>'."\n"; // Expediteur
$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
$headers .= 'Cc: '.$copie."\n"; // Copie Cc
$headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
$message = '<div style="width: 100%; text-align: left;">
          <br><br>
            Votre compte Felixdepanne vient d\'être supprimé.<br>
            Si cette action est anormale, veuillez contacter l\'administrateur du site.';
mail($destinataire, $objet, $message, $headers);



$delete=("DELETE FROM user WHERE id = :id");
$DB->delete($delete, array('id' => $id));

header('Location: userlist');
?>