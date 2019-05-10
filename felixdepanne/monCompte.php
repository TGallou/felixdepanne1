<?php
session_start();
include_once('includes/includeBD.php');

if(!isset($_SESSION['id'])){
	header('Location: index');
	exit;
}

$session = $DB->query('SELECT * from user');  
$session = $session->fetch();
?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.ico" />
  <title>Mon Compte</title>
  
</head>

<body>
<!-- Add header -->
	<?php include("includes/header.php"); ?>
<!-- End Add header -->

<form class="container monCompte">
			<h3 id="monCompte">Mon Compte</h3>
            <br>
            <div class="container">
                <table class="table table-striped table-hover table-bordered" style="margin-top:6%; margin-bottom:6%;">
                    <thead class="thead-dark">
                        <tr>
                            <th width="15%">Nom</th>
                            <th width="15%">Prénom</th>
                            <th width="20%">Email</th>
                        </tr>
                    </thead>
                    <tbody>               
                       <tr>
                            <td><?php echo $session['nom'];?></td>
                            <td><?php echo $session['prenom'];?></td>
                            <td><?php echo $session['email'];?></td>                          
                        </tr>
                    </tbody>
                </table>
            </div>

        <div class="row">
            <div class="col-sm-4">
             <a href="changePwd" style="text-decoration: none"> 
                 <img id="passlogo" src="img/pass.png" class="img-responsive">
            <div class="passdesc1"><p>Modifier</p></div>
            <div class="passdesc2"><p>Mot de passe</p></div>
            </a>
            </div>    
            
            <div class="col-sm-4">
             <a href="changeEmail" style="text-decoration: none"> 
                 <img id="emaillogo" src="img/email.png" class="img-responsive">
            <div class="emaildesc1"><p>Modifier</p></div>
            <div class="emaildesc2"><p>Email</p></div>
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