<?php
session_start();
include_once('includes/includeBD.php');

if(!empty($_POST)){
	extract($_POST);
$valid = false;

$reqNom = $DB->query("SELECT id from user where nom= '$Nom'");  
$reqNom = $reqNom->fetch();
$reqPrenom = $DB->query("SELECT id from user where prenom= '$Prenom'");  
$reqPrenom = $reqPrenom->fetch();
$reqMail = $DB->query("SELECT id from user where email= '$Mail'");  
$reqMail = $reqMail->fetch();

//Si les 3 id sont egaux
if($reqNom == $reqPrenom){
    if($reqPrenom == $reqMail){
        $valid = true;
    }
}

if($valid){  
//Genere mot de passe aleatoire
function Genere_Password($size)
{
    $password = "";
    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    for($i=0;$i<$size;$i++)
    {
        $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
    }		
    return $password;
}
$NewPassword = Genere_Password(8);

//Rempalce le mdp utilisateur par le mdp aleatoire
$changepwd=("UPDATE user SET password = :newpassword where id = :id");
$DB->insert($changepwd, array('id' => $reqNom['id'], 'newpassword' => (crypt($NewPassword, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t'))));

//Envoi mail à l'utilisateur avec le mdp aleatoire
        $destinataire = $Mail;
        // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
        $expediteur = 'felixdepanne@gmail.com';
        $copie = 'felixdepanne@gmail.com';
        $copie_cachee = 'felixdepanne@gmail.com';
        $objet = 'Changement de mot de passe'; // Objet du message
        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n";
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Support - Felixdepanne"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
        $headers .= 'Cc: '.$copie."\n"; // Copie Cc
        $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
        $message = '<div style="width: 100%; text-align: left;">
                  <br><br>
                    Vous avez réinitialisé votre mot de passe Felixdepanne.<br>
                    <br>
                    Voici votre mot de passe provisoire: '.$NewPassword.'<br>
                    Changez le dès que possible depuis le site.';
        if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
        {
          $_SESSION['flash']['success'] = "Un mot de passe temporaire vous a été envoyé par email.";
        }
        else // Non envoyé
        {
          $_SESSION['flash']['danger'] = "L'Email n'a pas pu être envoyé !";
        }
    }
    else{
        $_SESSION['flash']['danger'] = "Les informations de compte ne sont pas valides !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="icon" type="image/png" href="img/favicon.ico" />
	
	<title>Support - Felixdepanne</title>
</head>
<body>
<!-- Add header -->
	<?php include("includes/header.php"); ?>
<!-- End Add header -->	

		<?php 
		    if(isset($_SESSION['flash'])){ 
		        foreach($_SESSION['flash'] as $type => $message): ?>
				<p></p>
				<div id="alert" class="alert alert-<?= $type; ?> infoMessage">
					<?= $message; ?>
				</div>	
		    
		<?php
			    endforeach;
			    unset($_SESSION['flash']);
            }
		?>

	<form class="container inscription" method="post" action="">
		<fieldset>
			<h3 id="TitreInscription">Demande de réinitialisation</h3>
			<br>
	    <div class="form-row">
	    	<div class="form-group col-md-6">
	      		<label for="inputEmail4">Identité:</label>
	      		<input class="form-control" type="text" name="Nom" placeholder="Nom" maxlength="20" required="required">
	    	</div>
	    	<div class="form-group col-md-6">
	      		<label for="inputPassword4">&nbsp;</label>
	      		<input class="form-control" type="text" name="Prenom" placeholder="Prénom" required="required">
	    	</div>
	  	</div>
	  	<div class="form-group">
	    	<label for="inputAddress">Adresse email:</label>
	    	<input class="form-control" type="text" name="Mail" placeholder="Email" required="required">
	  	</div>               
				<button type="submit" class="btn btn-primary">Envoyer</button>
				<a href="connexion">Se connecter ?</a> 	                	                                                	    
	  </fieldset>
	</form>
	
<!-- Footer -->
	<?php include("includes/footer.php"); ?>
<!-- End Footer -->
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	
</body>
</html>