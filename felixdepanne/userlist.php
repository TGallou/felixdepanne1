<?php
session_start();
include_once('includes/includeBD.php');

// Restrict acces
include_once('includes/acces.php');
// Restrict acces
?>

<!DOCTYPE html>
<html>
    <head>
	    <meta charset="utf-8">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	    <link rel="stylesheet" href="css/style.css"/>
	    <link rel="icon" type="image/png" href="img/favicon.ico" />
	
	    <title>Liste des utilisateurs</title>
    </head>
    <body>
        <!-- Add header -->
	    <?php include("includes/header.php"); ?>
        <!-- End Add header -->

            <?php
                $requete = $DB->query('SELECT * from user ORDER BY nom ASC');  
                $requete->execute();
                $lignes = $requete->fetchAll();
            ?>

            <div class="container">
                <table class="table table-striped table-hover table-bordered" style="margin-top:6%; margin-bottom:6%;">
                    <thead class="thead-dark">
                        <tr>
                            <th width="15%">Nom</th>
                            <th width="15%">Prénom</th>
                            <th width="20%">Email</th>
                            <th width="12%" style="text-align:center">Modifier MDP</th>
                            <th width="12%" style="text-align:center">Supprimer Compte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($lignes as $ligne)
                            {
                        
                        ?>
                        <tr>
                            <td><?php echo $ligne['nom'];?></td>
                            <td><?php echo $ligne['prenom'];?></td>
                            <td><?php echo $ligne['email'].'<a href="changeUserEmail.php?id='.$ligne['id'].'"><img id="logomodif" src="img/logomodif.png"></a>';?></td>
                            <?php
                            echo'<td style="text-align:center;">
                                 <a href="changeUserPwd.php?id='.$ligne['id'].'"><button class="btn btn-warning">Modifier</button></a>                         
                                 </td>';  
                            ?> 
                            
                            <?php
                            if($ligne['droit'] != "admin"){
                            echo'<td style="text-align:center;">
                                <a href="deleteUser.php?id='.$ligne['id'].'"><button class="btn btn-danger" style="font-color: white;">Supprimer</button></a>                         
                                </td>';  
                             }
                             else{
                                echo'<td style="text-align:center;" >
                                <button class="btn btn-secondary" style="font-color: white;">Supprimer</button>
                                </td>';  
                             }                                                
                            }                        
                            ?>                           
                        </tr>
                    </tbody>
                </table>
            </div>

        <!-- Footer -->
        <?php include("includes/footer.php"); ?>
        <!-- End Footer -->

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	
    </body>
</html>