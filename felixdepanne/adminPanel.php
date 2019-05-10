<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.ico" />
  <title>Admin Panel</title>
  
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

	<form class="container AdminPanel">
			<h3 id="AdminPanel">Admin Panel</h3>
            <br> 

        <div class="row">
            <div class="col-sm-4">
             <a href="inscription" style="text-decoration: none"> 
                 <img id="adduserlogo" src="img/adduser.png" class="img-responsive">
            <div class="adduserdesc1"><p>Nouveau</p></div>
            <div class="adduserdesc2"><p>membre</p></div>
            </a>
            </div>    
            
            <div class="col-sm-4">
             <a href="userlist" style="text-decoration: none"> 
                 <img id="userlistlogo" src="img/userlist.png" class="img-responsive">
            <div class="userlistdesc1"><p>Modifier un</p></div>
            <div class="userlistdesc2"><p>compte</p></div>
            </a>
            </div>
        </div>  

        <div class="row">
        <div class="col-sm-4">
             <a href="intervention" style="text-decoration: none"> 
                 <img id="interventionlogo" src="img/intervention.png" class="img-responsive">
            <div class="interventiondesc1"><p>Saisir une</p></div>
            <div class="interventiondesc2"><p>intervention</p></div>
            </a>
            </div>
        </div>
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