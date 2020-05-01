
<?php

require("portal/include/dbinit.php");
$conn = (new db_connection())->get_conn();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Carousel Template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/carousel/">

    <!-- Bootstrap core CSS -->
<link href="http://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="bs-additions.css">
<link rel="icon" href="http://laurcons.ddns.net/media/favicon-16x16.ico">


    <style>
    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.4/examples/carousel/carousel.css" rel="stylesheet">
  </head>
  <body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand text-wrap" href="#">
      <img src="http://laurcons.ddns.net/media/favicon-32x32.png">
      Liceul Teoretic "Petru Maior"
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">

        <li class="nav-item active">
          <a class="nav-link" href="#">Acasă</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Despre noi</a>
        </li>

        <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Formulare</a>
          <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Înscrierea în învățământul primar</a>
              <a class="dropdown-item" href="#">Înscrierea în învățământul gimnazial</a>
              <a class="dropdown-item" href="#">Cerere de înscriere în învățământul liceal</a>
          </div>

        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Noutăți</a>
        </li>

      </ul>
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Căutare" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Căutare</button>
      </form>
    </div>
  </nav>
</header>

<main role="main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="http://laurcons.ddns.net/media/poze/poza1.png">
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Cel mai bun liceu din zonă.</h1>
            <p>Profesorii sunt bine pregătiți, elevii sunt stimulați în mod continuu, iar mediul este unul primitor și potrivit pentru învățare.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Înscrie-ți preșcolarul!</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="http://laurcons.ddns.net/media/poze/poza2.png">
        <div class="container">
          <div class="carousel-caption">
            <h1>Elevi olimpici la tot pasul.</h1>
            <p>Liceul este o sursă bogată de elevi olimpici la nivel județean și național, la materii precum limba română, limba engleză, sau informatică.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Vezi ultimele premii</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="http://laurcons.ddns.net/media/poze/poza3.png">
        <div class="container">
          <div class="carousel-caption text-right">
            <h1>Liceul ține pasul cu tehnologia.</h1>
            <p>Fiecare clasă este dotată cu videoproiectoare, fiecare catedră este dotată cu câte un laptop, iar școala deține un catalog electronic, ținând astfel pasul cu tehnologia, și aducând un element nou în procesul de învățare!</p>
            <p><a class="btn btn-lg btn-primary" href="/portal" role="button">Vezi Portal</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
  </div>


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">

      <div class="col-lg-4 order-2">
        <img src="http://laurcons.ddns.net/media/poze/pustai.png" style="border-radius:50%" height="140" class="mb-2">
        <h2>Pustai Alina-Ștefania</h2>
        <h4>Director</h4>
        <p>Interesată în permanență să creeze un mediu propice învățării, doamna director aduce un element de inovație în liceu în fiecare zi.</p>
        <!--<p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>-->
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4 order-3">
        <img src="http://laurcons.ddns.net/media/poze/onac.png" style="border-radius:50%" height="140" class="mb-2">
        <h2>Onac Olimpia</h2>
        <h4>Director Adjunct</h4>
        <p>Profesor de fizică și TIC, nu se dă în lături când vine vorba de a integra tehnologia în orele profesorilor liceului.</p>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4 order-md-1 order-3">
        <img src="http://laurcons.ddns.net/media/poze/urcan.png" style="border-radius:50%" height="140" class="mb-2">
        <h2>Urcan Larisa</h2>
        <h4>Profesor</h4>
        <p>Nu se ferește de elementul nou, și reușește să-și țină orele într-un mod dinamic și plăcut!</p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <h1 class="text-center mb-5">Ultimele noutăți</h1>

    <?php
      $stmt = $conn->prepare("SELECT * FROM noutati ORDER BY Creat DESC LIMIT 3;");
      $stmt->execute();
      $noutati = $stmt->get_result();

      $rownum = 0;

      while ($noutate = $noutati->fetch_assoc()) :
    ?>

    <div class="row featurette">
      <div class="col-md-7 <?= ($rownum % 2 == 1) ? 'order-2' : '' ?>">
        <h2 class="featurette-heading"><?= $noutate["Titlu"] ?></h2>
        <p class="lead"><?= $noutate["Sumar"] ?></p>
        <a class="btn btn-primary btn-lg" href="#">Citește mai mult</a>
      </div>
      <div class="col-md-5 <?= ($rownum % 2 == 1) ? 'order-1' : '' ?>">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <?php $rownum++ ?>

    <?php endwhile; ?>

    <div class="text-center">

      <a class="btn btn-lg btn-primary" href="#">Vezi toate noutățile</a>

    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-right"><a href="#">Înapoi sus</a></p>
    <p>&copy; <?= date('Y') ?> Echipa IT a liceului &middot; <a href="#">Despre Echipa IT</a> &middot; <a href="http://getbootstrap.com" target="_blank">Construit cu Bootstrap</a></p>
  </footer>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>feather.replace(); window.jQuery || document.write('<script src="http://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="http://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>
