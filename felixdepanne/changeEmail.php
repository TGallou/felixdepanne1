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
        
        $Email = htmlspecialchars(trim($Email));
        $NewEmail = htmlspecialchars(trim($NewEmail));
		$NewEmailConfirmation = htmlspecialchars(trim($NewEmailConfirmation));
		
		$EmailModif = strtolower($Email);
		$NewEmailModif = strtolower($NewEmail);
		
		$req = $DB->query("SELECT * from user where id = :id", array('id' => $_SESSION['id']));
		$req = $req->fetch();

	if(empty($Email)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez insérer votre Email actuel !";
	
	}elseif($NewEmail && empty($NewEmailConfirmation)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez confirmer votre nouvel Email";

	}else if($req['email'] != $EmailModif){
			$valid = false;
			$_SESSION['flash']['danger'] = "Email actuel incorrect !";

	}elseif($NewEmail != $NewEmailConfirmation){
		$valid = false;
		$_SESSION['flash']['danger'] = "Confirmation du nouvel Email invalide !";
		
	}else if(empty($NewEmail)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez insérer un nouvel Email !";

    }

    $reqEmail = $DB->query("SELECT email from user where email = '$NewEmailModif'");
	$reqEmail = $reqEmail->fetch();

	if(!empty($NewEmailModif) && $reqEmail['email']){
		$valid = false;
		$_SESSION['flash']['danger'] = "Cet email existe déjà";
		
	}

	if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $NewEmail)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner un email conforme !";
	}
    
        if($valid){
		
		$DB->insert("UPDATE user SET email = :newemail where id = :id", array('id' => $_SESSION['id'], 'newemail' => $NewEmailModif));
		
		$_SESSION['flash']['success'] = "Votre nouvel Email a été enregistré !";
		header('Location: changeEmail');
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
	
	<title>Modifier mon email</title>
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



	<form class="container changepwd" method="post" action="changeEmail">
		<fieldset>
			<h3 id="TitreChangepwd">Modifier mon email</h3>
			<br>
		<div class="form-group">
	    	<label>Email actuelle :</label>
	    	<input class="form-control" type="text" name="Email" placeholder="Email" value="<?php if (isset($Email)) echo $Email; ?>" required="required">
	  	</div>
	  	<div class="form-group">
	    	<label>Nouvelle email :</label>
	    	<input class="form-control" type="text" name="NewEmail" placeholder="Nouvelle Email" required="required">
	  	</div>
	  	<div class="form-group">
	    	<input class="form-control" type="text" name="NewEmailConfirmation" placeholder="Comfirmation Email" required="required">
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