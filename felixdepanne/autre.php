<?php
session_start();
include_once('includes/includeBD.php');

if(!isset($_SESSION['id'])){
	header('Location: index');
	exit;
}

if(!empty($_POST)){
	extract($_POST);
    $valid = true;
    
	if($valid){

        $typePanne = 'Autre';
        $datePanne = date("d/m/Y");

        $DB->insert('INSERT INTO pannes (numPoste, numSalle, objetPanne, typePanne, descriptif, datePanne) VALUES (:numPoste, :numSalle, :objetPanne, :typePanne, :descriptif, :datePanne)', array('numPoste' => $numPoste,'numSalle' => $numSalle,'objetPanne' => $objetPanne, 'typePanne' => $typePanne, 'descriptif' => $descriptif, 'datePanne' => $datePanne));
        
        //Nom de prof
        $nom = $DB->query('SELECT nom, prenom from user where id= '.$_SESSION['id'].'');  
        $nom = $nom->fetch();
        
        //Envoi mail à l'utilisateur avec le mdp aleatoire
        $destinataire = 'felixdepanne@gmail.com';
        // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
        $expediteur = 'felixdepanne@gmail.com';
        $copie = 'felixdepanne@gmail.com';
        $copie_cachee = 'felixdepanne@gmail.com';
        $objet = 'Panne de type "Autre"'; // Objet du message
        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=UTF-8'."\n";
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Support - Felixdepanne"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
        $headers .= 'Cc: '.$copie."\n"; // Copie Cc
        $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
        $message = '<div style="width: 100%; text-align: left;">
                    <br><br>
                    Une panne de type "Autre" a été déclarée par Mme/Mr '.$nom['nom'].' '.$nom['prenom'].'.<br>
                    <br>
                    Détails de la panne:<br>
                    Date: '.$datePanne.'<br>
                    Salle: N° '.$numSalle.'<br>
                    Poste: N° '.$numPoste.'<br>
                    Objet de la panne: '.$objetPanne.'<br>
                    Descriptif de la panne: '.$descriptif.'';
        if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
        {
          $_SESSION['flash']['success'] = "Votre panne a bien été envoyée à l'administrateur.";
        }
        else // Non envoyé
        {
          $_SESSION['flash']['danger'] = "L'Email n'a pas pu être envoyé !";
        }


		header('Location: autre');
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
	
	<title>Panne Autre</title>
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
        
    <div class="autreBanniere">
        <img id="autreImg" src="img/autreImg.jpg">
        <div class="centered">Autre</div>
    </div>

	<form class="container inscription" method="post" action="autre.php">
		<fieldset>
		<div class="form-row">
	    	<div class="form-group col-md-3">
            	<label for="inputNumSalle">N° Salle :</label>
	      		<input class="form-control" type="text" name="numSalle" placeholder="Ex: B321" value="<?php if (isset($numSalle)) echo $numSalle; ?>" required="required">
	    	</div>
        	<div class="form-group col-md-3">
          		<label for="inputNumPoste">N° poste :</label>
	      		<input class="form-control" type="number" name="numPoste" placeholder="Ex: 15" value="<?php if (isset($numPoste)) echo $NumPoste; ?>" required="required">
            </div>
            <div class="form-group col-md-6">
          		<label for="inputObjetPanne">Objet de la panne :</label>
	      		<input class="form-control" type="text" name="objetPanne" placeholder="Objet de panne" value="<?php if (isset($objetPanne)) echo $objetPanne; ?>" required="required">
            </div>
            <div class="form-group col-md-12">
          		<label for="inputDescriptif">Desriptif de la panne :</label>
	      		<input class="form-control" type="text" name="descriptif" placeholder="Décrivez la panne" value="<?php if (isset($descriptif)) echo $descriptif; ?>" required="required">
			</div>
	  	</div>
			<button type="submit" class="btn btn-primary">Envoyer</button>	                	                                                	    
	  	</fieldset>
	</form>

<!-- Footer -->
	<?php include("includes/footer.php"); ?>
<!-- End Footer -->


<!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>