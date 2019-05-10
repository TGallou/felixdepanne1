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
		
	$Password = trim($Password);
		$PasswordConfirmation =trim($PasswordConfirmation);
		$NewPassword = trim($NewPassword);
		
		$req = $DB->query("Select * from user where id = :id", array('id' => $_SESSION['id']));
		$req = $req->fetch();

	if(empty($Password)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez insérer votre mot de passe actuel !";
	
	}elseif($NewPassword && empty($PasswordConfirmation)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez confirmer votre nouveau mot de passe";

	}elseif($NewPassword != $PasswordConfirmation){
		$valid = false;
		$_SESSION['flash']['danger'] = "Confirmation du nouveau mot de passe invalide !";

	}else if($req['password'] != (crypt($Password, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t'))){
		$valid = false;
		$_SESSION['flash']['danger'] = "Mot de passe actuel incorrect !";
		
	}else if(empty($NewPassword)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez insérer un nouveau mot de passe !";

	}else if($valid){
		
		$DB->insert("UPDATE user SET password = :newpassword where id = :id", array('id' => $_SESSION['id'], 'newpassword' => (crypt($NewPassword, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t'))));
		
		$_SESSION['flash']['success'] = "Votre nouveau mot de passe a été enregistré !";
		header('Location: changePwd');
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
	
	<title>Modifier mon mot de passe</title>
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



	<form class="container changepwd" method="post" action="changepwd">
		<fieldset>
			<h3 id="TitreChangepwd">Modifier mon mot de passe</h3>
			<br>
		<div class="form-group">
	    	<label>Mot de passe actuel :</label>
	    	<input class="form-control" type="password" name="Password" placeholder="Mot de passe" value="<?php if (isset($NewPassword)) echo $NewPassword; ?>" required="required">
	  	</div>
	  	<div class="form-group">
	    	<label>Nouveau mot de passe :</label>
	    	<input class="form-control" type="password" name="NewPassword" placeholder="Nouveau mot de passe" value="<?php if (isset($NewPassword)) echo $NewPassword; ?>" required="required"> <!-- pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$" -->
	  	</div>
	  	<div class="form-group">
	    	<input class="form-control" type="password" name="PasswordConfirmation" placeholder="Comfirmation mot de passe" required="required">
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