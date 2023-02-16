<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Acceuil</title>
		<meta charset="utf-8">
	</head>

	<body>
		<h2> Page d'acceuil </h2>
		<br><br>

		<?php
		if(empty($_SESSION['id'])){
			header("Location: connexion.php");
			exit();
		}
		if ($_POST['deconnexion'] || $_POST['connexion']){
			session_destroy();
			header("Location: ../index.php");
		} 

		if (!empty($_SESSION['id']) AND !empty($_SESSION['username'])){
			echo "<p> Bienvenue " . $_SESSION['username'] . "! Vous êtes maintenant connecté à votre compte. </p>";
			?>
			<form method="POST" action="">
				<input type="submit" name="deconnexion" value="Déconnexion">
			</form>
			<?php
		}else{
			echo "Vous devez vous connectez pour accéder à cette page!";
			
			?>
			<form method="POST" action="">
				<input type="submit" name="connexion" value="connexion">
			</form>
			<?php
		}
		?>
		
	</body>
</html>