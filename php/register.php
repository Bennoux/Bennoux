<?php
  session_start();
  //if already logged IN
  if(isset($_SESSION['id'])){
    header("Location: ./chat.php" );
    exit();
  }
  if(isset($_POST['registerPHP'])){
    $connection = new PDO('mysql:host=localhost;dbname=db_network_project;','root',''); // Changer la dbname
    $email = $_POST['emailPHP'];
    $password = md5($_POST['passwordPHP']);
    $pseudo = $_POST['pseudoPHP'];

    $data = $connection->query("SELECT * FROM users WHERE email ='$email'");
    
    if($data->rowCount() == 0){

      $token = rand(1000000,9000000);
      $data = $connection->prepare("INSERT INTO users(pseudo,email,pswd,token,confirm) VALUES(?,?,?,?,?)");
      $data->execute(array($pseudo,$email,$password,$token,0));
      
      $data = $connection->query("SELECT * FROM users WHERE email ='$email' AND pswd='$password'");
      $userInfo = $data->fetch();
      $_SESSION['id'] = $userInfo['id'];

      $to   = $email;
      $from = 'devbennoux@gmail.com';
      $name = 'Benjamin';
      $subj = 'Email de Confirmation de compte';
      $msg = 'http://localhost/Projet/Projet_Reseau/php/verif.php?id='.$_SESSION['id'].'&token='.$token;

      $header="MIME-Version: 1.0\r\n";
      $header.='From:'.$name.'<'.$from.'>'."\n";
      $header.='Content-Type:text/html; charset="uft-8"'."\n";
      $header.='Content-Transfer-Encoding: 8bit';

      mail($to, $subj, $msg, $header);

    }else{
      // there is already this email in db
      exit('<font color="red">Email already registered.</font>');
    }
  }
?>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Inscription</title>
  </head>
  <body>
  <div class="login-form">
    <form action="register.php" method="POST">
        <h2 class="text-center">Inscription</h2>       
        <div class="form-group">
            <input type="text" id="pseudo" class="form-control" placeholder="Pseudo" required="required" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="email" id="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" id="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
        </div>
        <div class="form-group">
          <input type="button" id="register" class="btn btn-primary btn-block" value='Register'>
        </div>
        <p id="response"></p>
    </form>
      <p class="text-center"><a href="./login.php">Connexion</a></p>
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
        $("#register").on("click",function(){

          var email = $("#email").val();
          var password = $("#password").val();
          var pseudo = $("#pseudo").val();
          const regex_pswd = new RegExp('(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,})'); // 1 Maj / 1 Min / 1 Num / l Least 8 char
          const regex_email = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

          if(email =="" || password=="" || pseudo==""){
            $("#response").html('<font color="red">Please complete the form.</font>')
          }else{
            if(!regex_email.test(email)){
              $("#response").html('<font color="red">Invalid email.</font>')
            }else 
              if(!regex_pswd.test(password)){
                  $("#response").html('<font color="red">Your password is not enought complexe.</font>')
              }else{
                $.ajax({
                  type: "POST",
                  url: "register.php",
                  data: {
                    registerPHP: 1,
                    emailPHP: email,
                    passwordPHP: password,
                    pseudoPHP: pseudo
                  },
                  dataType: "test",
                  success: function (response) {
                    console.log(response);
                  }
                });
                $("#response").html('<font color="green">Registring.....</font>');
              }           
          }
        });
      });
    </script>
  </body>
</html>