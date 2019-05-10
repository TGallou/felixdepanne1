<?php
session_start();
include_once('includes/includeBD.php');	
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.ico" />
  <title>Accueil</title>
  
</head>

<body>
<!-- Add header -->
	<?php include("includes/header.php"); ?>
<!-- End Add header -->

<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="img/slide1.png" alt="Slide1">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/slide2.png" alt="Slide2">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/slide3.png" alt="Slide3">
    </div>
	<div class="carousel-item">
      <img class="d-block w-100" src="img/slide4.png" alt="Slide4">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>		
<!-- End Carousel -->

<div class="container-fluid">
<div class="row">
<div class="col-sm-4">
<?php
         if(!isset($_SESSION['id']))
         {																
          echo '<a href="connexion" style="text-decoration: none">';
         }
         else
         {
          echo '<a href="materiel" style="text-decoration: none">';
         }
?>
  <img id="materiellogo" src="img/materiel.png" class="img-responsive">
  <div class="materieldesc"><p>Materiel</p></div>
</a>
</div>

<div class="col-sm-4">
<?php
         if(!isset($_SESSION['id']))
         {																
          echo '<a href="connexion" style="text-decoration: none">';
         }
         else
         {
          echo '<a href="logiciel" style="text-decoration: none">';
         }
?>  
  <img id="logiciellogo" src="img/logiciel.png" class="img-responsive">
  <div class="logicieldesc"><p>Logiciel</p></div>
</a>
</div>

<div class="col-sm-4">
<?php
         if(!isset($_SESSION['id']))
         {																
          echo '<a href="connexion" style="text-decoration: none">';
         }
         else
         {
          echo '<a href="autre" style="text-decoration: none">';
         }
?>
  <img id="autrelogo" src="img/autre.png" class="img-responsive">
  <div class="autredesc"><p>Autre</p></div>
</a>
</div>

</div>
</div>
	
<!-- Footer -->
	<?php include("includes/footer.php"); ?>
<!-- End Footer -->


<!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>