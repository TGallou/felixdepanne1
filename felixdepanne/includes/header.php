<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>

<body>
	<nav class="navbar navbar-light bg-light">
		
	<a href="index"><img class="dantecminilogo" src="img/logo.png"></a>
	
    
    
	<?php
	
		
						if(!isset($_SESSION['id'])){																
							echo
						    '<div id="menuconnexion">
								<a href="connexion" class="connexionbtn"><i class="fas fa-sign-in-alt"></i> Connexion</a>
							 </div>';														
				    	}
						
						else{
							$reqdroit = $DB->query('Select droit from user where id = '.$_SESSION['id'].'');
							$reqdroit = $reqdroit->fetch();
							
							if($reqdroit['droit'] == "admin"){
								echo	
								'<div id="menu">
									<li id="userbtn"><i class="fas fa-user"></i> '.$_SESSION['identifiant'].'	
										<ul>
											<li id="profilbtn"><a href="monCompte"><i class="fas fa-user-cog"></i>&nbsp;Mon Compte</a></li>
											<li id="adminbtn"><a href="adminPanel"><i class="fas fa-wrench"></i>&nbsp;&nbsp;Admin Panel</a></li>
											<li id="infobtn"><a href="#"><i class="fas fa-info"></i>&nbsp;&nbsp;&nbsp;&nbsp;Infos</a></li>									
											<li id="deconnexionbtn"><a href="deconnexion"><i class="fas fa-power-off"></i>&nbsp;&nbsp;Déconnexion</a></li>									
										</ul>
									</li>			
								</div>';
							}
							
							else{
								echo	
								'<div id="menu">
									<li id="userbtn"><i class="fas fa-user"></i> '.$_SESSION['identifiant'].'	
										<ul>
											<li id="profilbtn"><a href="monCompte"><i class="fas fa-user-cog"></i>&nbsp;Mon Compte</a></li>
											<li id="infobtn"><a href="#"><i class="fas fa-info"></i>&nbsp;&nbsp;&nbsp;&nbsp;Infos</a></li>									
											<li id="deconnexionbtn"><a href="deconnexion"><i class="fas fa-power-off"></i>&nbsp;&nbsp;Déconnexion</a></li>									
										</ul>
									</li>			
								</div>';
							}
						}
						

	?>
	</nav>
</body>
</html>