<?php
  session_start();

  //if already logged IN
  if(isset($_SESSION['loggedIN'])){
    header("Location: ./chat.php" );
    exit();
  }

  if(isset($_POST['login'])){

    $connection = new PDO('mysql:host=localhost;dbname=db_network_project;','root',''); // Changer la dbname
    
    $email = $_POST['emailPHP'];
    $password = md5($_POST['passwordPHP']);
    $data = $connection->query("SELECT * FROM users WHERE email ='$email'");

    if($data->rowCount() > 0){ // there is an account with this email

      $data = $connection->query("SELECT * FROM users WHERE email ='$email' AND pswd='$password'");

      if($data->rowCount() > 0){ // there is an account with this email and password

        $userInfo = $data->fetch();

        if($userInfo['confirm']==1){ // the account is confirmed

          $res = date('Y-m-d H:i:s', time() - (3 * 60));

          if($res>=$userInfo['date_error']){ // the account is confirmed
              $updateConfirmation = $connection->query("UPDATE users SET num_error = 0 WHERE email = '$email'");
              $_SESSION['id'] = $userInfo['id'];
              $_SESSION['token'] = $userInfo['token'];
              $_SESSION['email'] = $userInfo['email'];
              $_SESSION['pseudo'] = $userInfo['pseudo'];
              exit("<font color='green'>Loggin success...</font>");
          }else{
            //mettre une erreur de compte bloqué
            exit('<font color="red">Your account is blocked for 3 minutes.</font>');
          }
        }else{
          //mettre une erreur de confirmation
          exit('<font color="red">Your account is not confirmed. Please check your email.</font>');
        }
      }else{
        
        $data = $connection->query("SELECT * FROM users WHERE email ='$email'");
        $userInfo = $data->fetch();

        if($userInfo['num_error'] != 3)
        {
          $val = $userInfo['num_error'] +1;
          $updateConfirmation = $connection->query("UPDATE users SET num_error = '$val' WHERE email = '$email'");
          if($val == 3){              
            $updateConfirmation = $connection->prepare('UPDATE users SET date_error = ? WHERE email = ?');
            $updateConfirmation->execute(array(date('Y-m-d H:i:s'),$email));
          }
        }
        exit('<font color="red">Your password or email is incorrect.</font>');
      }
    }else{
      //mettre une erreur de mauvaise id ou mdp
      exit('<font color="red">Please check your inputs</font>');
    }
  }
?>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Connexion</title>
  </head>
  <body>
    <div class="login-form">
      <form action="login.php" method="POST">
          <h2 class="text-center">Connexion</h2>       
          <div class="form-group">
              <input type="email" id="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
          </div>
          <div class="form-group">
              <input type="password" id="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
          </div>
          <div class="form-group">
              <input type="button" id="login" class="btn btn-primary btn-block" value='Log In' >
          </div> 
          <p id="response"></p>
      </form>
      <p class="text-center"><a href="./register.php">Inscription</a></p>
    </div>
    <style>
        .login-form {
            width: 340px;
            margin: 50px auto;
        }
        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }
        .login-form h2 {
            margin: 0 0 15px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {        
            font-size: 15px;
            font-weight: bold;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#login").on("click",function(){

          var email = $("#email").val();
          var password = $("#password").val();
          if(email =="" || password==""){
            $("#response").html('<font color="red">Please complete the form.</font>')
          }else{
            $.ajax({
              type: "POST",
              url: "login.php",
              data: {
                login: 1,
                emailPHP: email,
                passwordPHP: password
              },
              dataType: "text",
              success: function (response) {
                console.log(response);
                $("#response").html(response);
                if(response.indexOf("success")>=0){
                  window.location = './chat.php';
                }
              }
            });
          }
        });
      });
    </script>
  </body>
</html>