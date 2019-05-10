<?php
session_start();
include_once('includes/includeBD.php');

if(!empty($_POST)){
	extract($_POST);
    $valid = true;

    if($valid){
			
			// Email du premier admin créé dans la BDD
			$IdAdmin = $DB->query('SELECT MIN(id) from user where droit= "admin"');  
			$IdAdmin = $IdAdmin->fetch();

			$EmailAdmin = $DB->query('SELECT email from user where id= '.$IdAdmin['MIN(id)'].'');  
			$EmailAdmin = $EmailAdmin->fetch();
			// Fin selection Email premier admin

        $destinataire = $EmailAdmin['email'];
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
                    Un utilisateur a oublié son mot de passe:<br>
                    <br>
                  Nom:  '.$Nom.'<br>
                  Prenom:  '.$Prenom.'<br>
                  Email:  '.$Mail.'</div>';
        if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
        {
          $_SESSION['flash']['success'] = "Votre requête a bien été envoyé !";
        }
        else // Non envoyé
        {
          $_SESSION['flash']['danger'] = "Requête impossible !";
        }
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