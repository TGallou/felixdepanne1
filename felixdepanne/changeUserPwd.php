<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces

$id = (int)$_GET['id'];

if($id != 0){
	//Delete ancien id
	$requete = $DB->query('DELETE from id_temp_tab');  
	$requete->execute();
	//Insert id actuel
	$insert_id_temp = ("INSERT into id_temp_tab (id_temp) values (:id_temp)");
	$DB->insert($insert_id_temp, array('id_temp' => $id));

	//Recuperation id actuel dans $id_temp
	$id_temp = $DB->query('SELECT id_temp from id_temp_tab');  
	$id_temp = $id_temp->fetch();

	$session = $DB->query('SELECT * from user where id= '.$id_temp['id_temp'].'');  
	$session = $session->fetch();
}
else{
	header('Location: userlist');
}


if(!empty($_POST)){
	extract($_POST);
	$valid = true;
		
			//Recuperation id actuel dans $id_temp
			$id_temp = $DB->query('SELECT id_temp from id_temp_tab');  
			$id_temp = $id_temp->fetch();

			$changepwd=("UPDATE user SET password = :newpassword where id = :id");
			$DB->insert($changepwd, array('id' => $id_temp['id_temp'], 'newpassword' => (crypt($NewPassword, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t'))));

			header('Location: userlist');	


	//Envoi Email
	$Email = $DB->query('SELECT email from user where id= '.$id_temp['id_temp'].'');  
	$Email = $Email->fetch();

	if($valid){

        $destinataire = $Email['email'];
        // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
        $expediteur = 'felixdepanne@gmail.com';
        $copie = 'felixdepanne@gmail.com';
        $copie_cachee = 'felixdepanne@gmail.com';
        $objet = 'Changement de mot de passe'; // Objet du message
        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=UTF-8'."\n";
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Support - Felixdepanne"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
        $headers .= 'Cc: '.$copie."\n"; // Copie Cc
        $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
        $message = '<div style="width: 100%; text-align: left;">
                  <br><br>
                    Le mot de passe correspondant à l\'Email "'.$Email['email'].'" a été modifié. <br>
                    Utilisez maintenant le mot de passe: "'.$NewPassword.'" pour vous connecter';
        mail($destinataire, $objet, $message, $headers); // Envoi du message
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
	
	<title>Modifier un mot de passe</title>
</head>
<body>
<!-- Add header -->
	<?php include("includes/header.php"); ?>
<!-- End Add header -->	



	<form class="container changepwd" method="post" action="changeUserPwd">
		<fieldset>
			<h3 id="TitreChangepwd">Modifier un mot de passe</h3>

			<form class="container changeUserPwd">
            <div class="container">
                <table class="table table-striped table-hover table-bordered" style="margin-top:6%; margin-bottom:6%;">
                    <thead class="thead-dark">
                        <tr>
                            <th width="20%">Nom</th>
                            <th width="20%">Prénom</th>
                            <th width="20%">Identifiant</th>
                        </tr>
                    </thead>
                    <tbody>               
                       <tr>
                            <td><?php echo $session['nom'];?></td>
                            <td><?php echo $session['prenom'];?></td>
                            <td><?php echo $session['identifiant'];?></td>             
                        </tr>
                    </tbody>
                </table>
			</div>
	</form>
<br>
	  	<div class="form-group">
	    	<label for="inputAddress">Mot de passe:</label>
	    	<input class="form-control" type="text" name="NewPassword" placeholder="Nouveau MDP" value="<?php if (isset($NewPassword)) echo $NewPassword; ?>" required="required">
	  	</div>                         
				<button type="submit" class="btn btn-primary">Modifier</button>	                	                                                	    
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