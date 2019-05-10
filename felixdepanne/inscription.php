<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces

if(!empty($_POST)){
	extract($_POST);
	$valid = true;
	
	
	$Password = trim($Password);
	$PasswordConfirmation = trim($PasswordConfirmation);
	$Email = htmlspecialchars(trim($Email));
	$EmailConfirmation = htmlspecialchars(trim($EmailConfirmation));
	
	if(empty($Nom)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un nom !";
	}
	
	if(empty($Prenom)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un prenom !";
	}
	
	if(empty($Email)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un email !";

	}elseif($Email && empty($EmailConfirmation)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez confirmer l'adresse mail' !";
	
	}elseif(!empty($Email) && !empty($EmailConfirmation)){
		if($Email != $EmailConfirmation){
			
			$valid = false;
			$_SESSION['flash']['danger'] = "Confirmation de l'email incohérente !";
		}
	}		

	$reqEmail = $DB->query('Select email from user where email = :email', array('email' => $Email));
	$reqEmail = $reqEmail->fetch();

	if(!empty($Email) && $reqEmail['email']){
		$valid = false;
		$_SESSION['flash']['danger'] = "Cet email existe déjà";
		
	}

	if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $Email)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un email conforme !";
	}

	if(empty($Password)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un mot de passe !";

	}elseif($Password && empty($PasswordConfirmation)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez confirmer le mot de passe !";
	
	}elseif(!empty($Password) && !empty($PasswordConfirmation)){
		if($Password != $PasswordConfirmation){
			
			$valid = false;
			$_SESSION['flash']['danger'] = "Confirmation du mot de passe incohérente !";
		}		
	}
	
/*Anti doublon*/	
$NomModif = ucfirst(strtoupper($Nom));
$PrenomModif = ucfirst(strtolower($Prenom));
$reqIdMax = $DB->query("SELECT MAX(id) as maxid from user");  
$reqIdMax = $reqIdMax->fetch();
$compteur = 0;

while($compteur <= $reqIdMax['maxid']){
$compteur = $compteur+1;

$req = $DB->query("SELECT * from user where id='$compteur'");
$req = $req->fetch();

	if($req['nom'] == $NomModif){
		if($req['prenom'] == $PrenomModif){
				$reqId = $DB->query("SELECT id from user where nom = '$NomModif' and prenom = '$PrenomModif'");  
				$reqId = $reqId->fetch();
				$valid = false;
				$_SESSION['flash']['danger'] = "Compte déja existant !";
		}
	}
}
/*Fin Anti doublon*/	
	
		
	if($valid){
		
		
		$PrenomLOWER = strtolower($Prenom);
		$NomLOWER = strtolower($Nom);
		$identifiant = substr($PrenomLOWER, 0, 1).$NomLOWER;
		$EmailModif = strtolower($Email);
		
		$DB->insert('Insert into user (nom, prenom, identifiant, email, password) values (:nom, :prenom, :identifiant, :email, :password)', array('nom' => ucfirst(strtoupper($Nom)), 'prenom' => ucfirst(strtolower($Prenom)), 'identifiant' => $identifiant, 'email' => $Email, 'password' => crypt($Password, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t')));
	
		$_SESSION['flash']['success'] = "Le compte de Mme/Mr '".ucfirst(strtoupper($Nom))." ".ucfirst(strtolower($Prenom))."' a bien été créé.";

		//Envoi Email à l'utilisateur avec paramètres de connexion
			$destinataire = $Email;
			// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
			$expediteur = 'felixdepanne@gmail.com';
			$copie = 'felixdepanne@gmail.com';
			$copie_cachee = 'felixdepanne@gmail.com';
			$objet = 'Creation de compte'; // Objet du message
			$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
			$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
			$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
			$headers .= 'From: "Support - Felixdepanne"<'.$expediteur.'>'."\n"; // Expediteur
			$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
			$headers .= 'Cc: '.$copie."\n"; // Copie Cc
			$headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
			$message = '<div style="width: 100%; text-align: left;">
								<br><br>
									La création de votre compte Felixdepanne vient d\'être éffectué.<br><br>
									Voici vos paramètres de connexion:<br>
									Identifiant:  '.$EmailModif.' <br>
									Mot de passe: '.$Password.'';
			mail($destinataire, $objet, $message, $headers); // Envoi du message
		//Fin envoi email

		header('Location: inscription');
		exit;	
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
	
	<title>Inscription</title>
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

	<form class="container inscription" method="post" action="inscription.php">
		<fieldset>
			<h3 id="TitreInscription">Enregistrer un enseignant</h3>
			<br>
	    <div class="form-row">
	    	<div class="form-group col-md-6">
	      		<label for="inputEmail4">Identité:</label>
	      		<input class="form-control" type="text" name="Nom" placeholder="Nom" value="<?php if (isset($Nom)) echo $Nom; ?>" maxlength="20" required="required">
	    	</div>
	    	<div class="form-group col-md-6">
	      		<label for="inputPassword4">&nbsp;</label>
	      		<input class="form-control" type="text" name="Prenom" placeholder="Prénom" value="<?php if (isset($Prenom)) echo $Prenom; ?>" required="required">
	    	</div>
				<div class="form-group col-md-12">
				<label for="inputEmail">Adresse email:</label>
	      		<input class="form-control" type="text" name="Email" placeholder="Email" value="<?php if (isset($Email)) echo $Email; ?>" required="required">
	    	</div>
				<div class="form-group col-md-12">
	      		<input class="form-control" type="text" name="EmailConfirmation" placeholder="Confirmation de l'email" required="required">
	    	</div>
	  	</div>
	  	<div class="form-group">
	    	<label for="inputAddress">Mot de passe:</label>
	    	<input class="form-control" type="password" name="Password" placeholder="Mot de passe" required="required">
	  	</div>
	  	<div class="form-group">
	    	<input class="form-control" type="password" name="PasswordConfirmation" placeholder="Confirmation du mot de passe" required="required">
	  	</div>                         
				<button type="submit" class="btn btn-primary">Enregistrer le compte</button>	                	                                                	    
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