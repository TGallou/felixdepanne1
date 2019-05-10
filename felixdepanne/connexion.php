<?php
session_start();
include_once('includes/includeBD.php');

if(isset($_SESSION['identifiant'])){
	header('Location: index.php');
	exit;
}

if(!empty($_POST)){
	extract($_POST);
	$valid = true;
	
	$Password = trim($Password);
		
	if(empty($Email)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez renseigner votre Email !";
	}
	
	if(empty($Password)){
		$valid = false;
		$error_password = "Veuillez renseigner un mot de passe !";
	}
	
	
	$req = $DB->query('Select * from user where email = :email and password = :password', array('email' => $Email, 'password' => crypt($Password, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t')));
	$req = $req->fetch();
		
	if(!$req['email']){
		$valid = false;
		$_SESSION['flash']['danger'] = "Votre Email ou mot de passe est incorrect";
	}
	
	
	if($valid){
		
		$_SESSION['id'] = $req['id'];
		$_SESSION['identifiant'] = $req['identifiant'];
		$_SESSION['email'] = $req['email'];

		header('Location: index');
		exit;
			
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="icon" type="image/png" href="img/favicon.ico" />
		<title>Connexion</title>
	</head>

	<body class="connexion">
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
	
	<div class="container formulaire">
		

	
		<div class="container-fluid">
			<h3 id="TitreConnexion">Connexion</h3>
			<br>
			<form class="con-form" method="post" action="">
				                             
	                    <div class="form-group">
							<label>Email:</label>	
							<input class="form-control" type="text" name="Email" placeholder="Email" value="<?php if (isset($Email)) echo $Email; ?>" required="required">						
						</div>
						
						<div class="form-group">
							<label>Mot de passe:</label>	                    	
							<?php
								if(isset($error_password)){
									echo $error_password."<br/>";
								}	
							?>
							<input class="form-control" type="password" name="Password" placeholder="Mot de passe" value="<?php if (isset($Password)) echo $Password; ?>" required="required">
						</div>
	
	
	                    <button type="submit" class="btn btn-primary">Se connecter</button>

								<a href="oublieMdp">Mot de passe oublié ?</a>        
			</form>		
		</div>
	</div>
	
<!-- Footer -->
	<?php include("includes/footer.php"); ?>
<!-- End Footer -->
	</body>
</html>