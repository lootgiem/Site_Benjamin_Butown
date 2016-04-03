<?php 
include("api/data.php");

$message = '';

if(isset($_GET['mail']) && isset($_GET['token']))
	{
		if(isset($_POST['password']) && isset($_POST['passwordRepeat']) && !empty($_POST['password']) && !empty($_POST['passwordRepeat']))
		{	
			$password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
			$passwordRepeat = htmlentities($_POST['passwordRepeat'], ENT_QUOTES, "UTF-8");

			if($password == $passwordRepeat)
			{	
				$select_user = $bdd->prepare('SELECT tokenValidity FROM users WHERE mail= ? AND tokenPass= ?');
				$select_user->execute(array($_GET['mail'],$_GET['token']));
		
				$requete = $select_user->fetchAll( PDO::FETCH_ASSOC );
				
				if(empty($requete))
				{
					$message = return_message(6);
					header('Location: index.php?page=reset_pass&m_n='.urlencode($message).'&mail='.$_GET['mail'].'&token='.$_GET['token']);
					exit(); 
				}
				else
				{
					$validity = $requete[0]['tokenValidity'];
				
					if($validity != 1)
					{
						$message = "Ce token n'est plus valide !";
						header('Location: index.php?page=reset_pass&m_n='.urlencode($message).'&mail='.$_GET['mail'].'&token='.$_GET['token']);
						exit(); 
					}
					else
					{			
						$passHash = sha1(sha1($password));	
						$update_pass = $bdd->prepare('UPDATE users SET mdp = ?, tokenValidity = 0 WHERE mail = ?');
						$update_pass->execute(array($passHash,strtolower($_GET['mail'])));
						$message = "Mot de passe changé";
						header('Location: index.php?page=profil&m_p='.urlencode($message));
						exit(); 
					}
				}	
			}
			else
			{
				$message = return_message(14);
				header('Location: index.php?page=reset_pass&m_n='.urlencode($message).'&mail='.$_GET['mail'].'&token='.$_GET['token']);
				exit(); 			
			}
		}
		else{
			$message = return_message(4);
			header('Location: index.php?page=reset_pass&m_n='.urlencode($message).'&mail='.$_GET['mail'].'&token='.$_GET['token']);
			exit(); 
		}
	}
	else
	{
		$message = return_message(6);
		header('Location: index.php?page=reset_pass&m_n=isset'.urlencode($message).'');
		exit(); 
	}
?>