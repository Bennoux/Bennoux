<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=db_network_project;','root','');

if (isset($_GET['id']) AND !empty($_GET['id']) AND isset($_GET['token']) AND !empty($_GET['token'])) {
  $getid = $_GET['id'];
  $getcle = $_GET['token'];
  $recupUser = $bdd-> prepare('SELECT * FROM users WHERE id = ? AND token = ?');
  $recupUser->execute(array($getid,$getcle));
  if ($recupUser->rowCount() > 0) {
    $userInfo = $recupUser->fetch();
    if ($userInfo['confirm'] !=1) {
      $updateConfirmation = $bdd->prepare('UPDATE users SET confirm = ? WHERE id = ?');
      $updateConfirmation->execute(array(1,$getid));
      $_SESSION['token']=$getcle;
      $_SESSION['pseudo'] = $userInfo['pseudo'];
      header('Location: ./chat.php');
    }else{
      $_SESSION['cle']=$getcle;
      $_SESSION['pseudo'] = $userInfo['pseudo'];
      header('Location: ./chat.php');
    }
  }else{
    echo '<script type="text/javascript">alert("Votre clé ou identifiant est incorrect.") </script>';
  }
}else{
  echo '<script type="text/javascript">alert("Aucun utilisateur trouvé.") </script>';
}
?>