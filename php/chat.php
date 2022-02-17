<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">  
  <title>Chat-Web</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sticky-footer-navbar/">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
    input::placeholder{
      text-align:center;
    }

  </style>
  <!-- Custom styles for this template -->
  <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
  <link href="../css/chat.css" rel="stylesheet">
</head>
<body>
<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="./chat.php">Chat-Web</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Deconnexion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<section class="chat">
  <!-- Begin page content -->
  <main class="flex-shrink-0">
    <div class="container">
      <h1 class="mt-5">Bonjour <?php  echo $_SESSION['pseudo'];?> </h1>
      <div class="messages">
        <div class="message">

        </div>
      </div>
    </div>
  </main>

  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">    
      <form action="./handler.php?task=write" method="POST">
        <input class="col-md-12 themed-grid-col" type="text"  id="content" name="content" placeholder="Message"/>
        <button class="col-md-auto themed-grid-col" type="submit" name="valider" >Envoyer</button>
      </form>
    </div>
  </footer>
</section>
<script src="../js/chat.js"></script>
</body>
</html>