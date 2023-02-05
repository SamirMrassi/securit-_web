<?php
	require('./config.php');
	// Initialiser un conteur pour limiter les tentatives de connexion
	define("MAX_ATTEMPTS", 3);
	define("WAIT_INTERVAL", 60);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Authentification</title>
		<meta charset="utf-8">
	</head>

	<body>
		<h2> Page de connexion </h2>
		<h4> Connectez-Vous à votre compte: </h4>
		<form method="POST" action="">
			<p> Nom d'utilisateur: 
			<input type="text" name="connexion_username"></p>
			<p> Mot de passe: 
			<input type="password" name="connexion_password"></p>
			<input type="reset" value="Reset">
			<input type="submit" name="connexion" value="Valider">
		</form>

		<?php 
		if (isset($_POST['connexion'])){
			if (!empty($_POST['connexion_username']) AND !empty($_POST['connexion_password'])){

				// Verifier que l'utilisateur est enregistré dans la BD
				$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
				$username = htmlspecialchars($_POST['connexion_username']);
			    $stmt->bind_param("s", $username);
			    $stmt->execute();
			    $username_existence = $stmt->get_result();

			    if ($username_existence->num_rows == 1){
			    	// Vérifier le nombre de tentatives de connexion
			    	if (isset($_SESSION['attempts'])) {
						if ($_SESSION['attempts'] >= MAX_ATTEMPTS) {
							$time_left = time() - $_SESSION['last_attempt_time'];
							if ($time_left < WAIT_INTERVAL) {
								// Calculate time left for user to wait
								$time_left = WAIT_INTERVAL - $time_left;
								echo "Too many login attempts. Please try again in $time_left seconds.";
								exit;
							}
							else {
							  // Reset le nombre de tentatives de connexion si la durée d'attente s'est découlée.
							  $_SESSION['attempts'] = 0;
							  $_SESSION['last_attempt_time'] = null;
							}
						}
					}
			    	// Comparer le hah_password enregistré dans la BD avec celui saisie par l'utilisateur
			    	$stmt = $conn->prepare("SELECT id,password FROM users WHERE username = ?");
				    $stmt->bind_param("s", $username);
				    $stmt->execute();
				    $result = $stmt->get_result();
				    $row = $result->fetch_assoc();
					$password_given = htmlspecialchars($_POST['connexion_password']);
				    
			    	if (password_verify($password_given, $row['password'])){
			    		// Remplir les informations de session
			    		$id = $row['id'];
			    		$_SESSION['id'] = $id;
			    		$_SESSION['username'] = $username;
			    		$_SESSION['attempts'] = 0;
			    		// Rediriger l'utilisateur vers la page de double authentification
						header("Location: acceuil.php");
						exit;
			    	}else{
			    		echo "<p style='color:red'>Votre mot de passe est incorrect! </p>";
			    		// Incrémenter le nombre de tentaqtives de connexion si le mdp donné est faux.
						$_SESSION['attempts']++;
						$_SESSION['last_attempt_time'] = time();
			    	}
			    }else{
			     	echo "<p style='color:red'>le nom d'utilisateur n'existe pas! Veuillez vous inscrire.</p>"; 
			    }
			}else{
				echo "<p style='color:red'>Veuillez compléter tous les champs!</p>";
			}
		}
		?>

		<h4> Vous n'avez pas de compte?  </h4>
		<a href="inscription.php" > Inscrivez-vous!</a>

	</body>
</html>