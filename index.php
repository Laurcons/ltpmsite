
<?php

require("portal/include/dbinit.php");
$conn = (new db_connection())->get_conn();

?>

<!doctype html>
<html lang="ro">
  <head>
    <title>LTPM Ocna Mureș</title>

    <?php require("snips/bootstrap-head.php"); ?>

    <link rel="icon" href="http://laurcons.ddns.net/media/favicon-16x16.ico">
    <link rel="stylesheet" href="style/index.css">

  </head>
<body>
<header>
  <?php require("snips/navbar.php"); ?>
</header>

<main role="main">

  <div id="main-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
      <li data-target="#main-carousel" data-slide-to="1"></li>
      <li data-target="#main-carousel" data-slide-to="2"></li>
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
    <a class="carousel-control-prev" href="#main-carousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#main-carousel" role="button" data-slide="next">
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
  <?php require("snips/footer.php"); ?>
</main>
</body>
</html>
