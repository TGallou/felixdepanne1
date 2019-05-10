<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces

if(!empty($_POST)){
	extract($_POST);
	$valid = true;

	if(!preg_match("#^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$#", $laDate)){
		$valid = false;
		$_SESSION['flash']['danger'] = "Veuillez renseigner une date conforme ! (jj/mm/aaaa)";
}

if(!preg_match("#^\d\d?[.]\d\d?$#", $CoutIntervention)){
	if(!preg_match("#^[-+]?\d*$#", $CoutIntervention)){
	$valid = false;
	$_SESSION['flash']['danger'] = "Veuillez renseigner un coût conforme ! (Format 'xx.xx' ou 'xx')";
	}
}

	if($valid){

		$DB->insert('INSERT INTO intervention (laDate, duree, salle, numeroPoste, typeIntervention, coutIntervention) VALUES (:laDate, :duree, :salle, :numeroPoste, :typeIntervention, :coutIntervention)', array('laDate' => $laDate,'duree' => $Duree,'salle' => $Salle, 'numeroPoste' => $NumeroPoste, 'typeIntervention' => $TypeIntervention, 'coutIntervention' => $CoutIntervention));

		$_SESSION['flash']['success'] = "Votre intervention a bien été prise en compte.";
		header('Location: intervention');

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
	
	<title>Intervention</title>
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

	<form class="container inscription" method="post" action="intervention.php">
		<fieldset>
			<h3 id="TitreInscription">Intervention</h3>
			<br>
	    <div class="form-row">
			<div class="form-group col-md-6">
	      		<label for="inputDate">Date :</label>
	      		<input class="form-control" type="text" name="laDate" placeholder="jj/mm/aaaa" value="<?php if (isset($laDate)) echo $laDate; ?>" required="required">					
	    	</div>

	    	<div class="form-group col-md-6">
	      		<label for="inputDuree">Durée :</label>
	      		<input class="form-control" type="time" name="Duree" placeholder="Duree" value="<?php if (isset($Duree)) echo $Duree; ?>" required="required">
	    	</div>
		</div>

		<div class="form-row">
	    	<div class="form-group col-md-6">
            	<label for="inputSalle">N° Salle :</label>
	      		<input class="form-control" type="text" name="Salle" placeholder="Ex: B321" value="<?php if (isset($Salle)) echo $Salle; ?>" required="required">
	    	</div>
        	<div class="form-group col-md-6">
          		<label for="inputNumeroPoste">N° poste :</label>
	      		<input class="form-control" type="text" name="NumeroPoste" placeholder="Ex: 15" value="<?php if (isset($NumeroPoste)) echo $NumeroPoste; ?>" required="required">
			</div>
	  	</div>
		  
	  	<div class="form-group">
	    	<label for="selTypeIntervention">Type d'intervention :</label>
	    	<select class="form-control" type="text" name="TypeIntervention" placeholder="TypeIntervention" value="<?php if (isset($TypeIntervention)) echo $TypeIntervention; ?>" required="required">
				<option>Matérielle</option>
				<option>Logicielle</option>
				<option>Autre</option>
			</select>
	  	</div>
	  	<div class="form-group">
		  	<label for="inputCout">Coût (€):</label>
	    	<input class="form-control" type="text" name="CoutIntervention" placeholder="Format: 'xx.xx' ou 'xx'" value="<?php if (isset($CoutIntervention)) echo $CoutIntervention; ?>" required="required">
	  	</div>                         
			<button type="submit" class="btn btn-primary">Valider</button>	                	                                                	    
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