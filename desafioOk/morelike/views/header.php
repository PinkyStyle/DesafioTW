<!DOCTYPE html>
<html lang="es">

<head>

  <title>Desafio</title>

  <!-- Bootstrap core CSS -->
  <link href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?=base_url()?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  
  <!--script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Custom styles for this template -->
  <link href="<?=base_url()?>css/agency.css" rel="stylesheet">

  <!--script src="<?=base_url()?>js/jquery.form.min.js"></script-->
  <script type="text/javascript">
      var base_url = '<?=base_url()?>';
  </script>
  <script type="text/javascript">
    $(document).ready(function(){       
      $(".carousel").carousel({
        interval:6000
      });
      if(screen.width<=480){
        $(".navbar-brand").css({"width":"30%"});
        //$("#mainNav").css("background-color","rgba(124, 138, 195,0.8)");
      }
    });
    
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $("#myBtn").css("display","block");
       
      } else {
        $("#myBtn").css("display","none");
        if(screen.width>480){
          $("#sobreNav").fadeIn();
        }
      }
    }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

  </script>
  <style type="text/css">
    /*body{
      font-family:'Lato';
    }*/
    
    #myBtn {
        display: none; /* Hidden by default */
        position: fixed; /* Fixed/sticky position */
        bottom: 20px; /* Place the button at the bottom of the page */
        right: 30px; /* Place the button 30px from the right */
        z-index: 99; /* Make sure it does not overlap */s
        border: none; /* Remove borders */
        outline: none; /* Remove outline */
        background-color: red; /* Set a background color */
        color: white; /* Text color */
        cursor: pointer; /* Add a mouse pointer on hover */
        padding: 15px; /* Some padding */
        border-radius: 10px; /* Rounded corners */
        font-size: 18px; /* Increase font size */
      }

      #myBtn:hover {
        background-color: #555; /* Add a dark-grey background on hover */
      }
      .carousel-item {
        height: 300px;
      }

      .carousel-item img {
          /*position: absolute;*/
          /*top: 0;*/
          /*left: 0;*/
          min-height: 300px;
      }        
    </style>
</head>
<body id="inicio">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
  <div class="container">
    
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link js-scroll-trigger" href="#equipo">Equipo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  <!--nav class="navbar navbar-expand-lg navbar-light bg-light static-top fixed-top" style="background: white">
      <a class="navbar-brand js-scroll-trigger AA" href="#inicio" style=" width: 20%;">
        <img id="logoMV" src="<?=base_url()?>img/logo1.png" style="width: 30%;" alt="">
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#equipo">Equipo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger"  href="#examenes">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger"  href="#contact">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger"  href="Intranet">Intranet</a>
          </li>
        </ul>
      </div>
    
  </nav-->

  <!-- Header -->
  <header class="masthead">
    <div id="asd" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <!--li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li-->
          <li data-target="#asd" class="active" data-slide-to="0"></li>
          <li data-target="#asd" data-slide-to="1"></li>
          <li data-target="#asd" data-slide-to="2"></li>
          <li data-target="#asd" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <img class="img-fluid" src='<?=base_url()?>img/enf1.png'>
            <div class="carousel-caption" style="background-color:#0675ad;opacity: 90%;padding: 0;">
              <p class="lead" style="color:white; font-weight: bolder;">Coronavirus: La Prevención es tarea de todos.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img class=" img-fluid" src='<?=base_url()?>img/enf2.png'>
            <div class="carousel-caption" style="background-color:#0675ad;opacity: 90%;padding: 0;">
              <p class="lead" style="color:white; font-weight: bolder;">Coronavirus: La Prevención es tarea de todos.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img class=" img-fluid" src='<?=base_url()?>img/enf3.png'>
            <div class="carousel-caption" style="background-color:#0675ad;opacity: 90%;padding: 0;">
              <p class="lead" style="color:white; font-weight: bolder;">#ElMejorEquipoMedico</p>
            </div>
          </div>
          <div class="carousel-item">
            <img class=" img-fluid" src='<?=base_url()?>img/enf4.png'>
            <div class="carousel-caption" style="background-color:#0675ad;opacity: 90%;padding: 0;">
              <p class="lead" style="color:white; font-weight: bolder;">#QuédateEnCasa</p>
            </div>
          </div>
        </div>
      
        <a class="carousel-control-prev" href="#asd" role="button" data-slide="prev">
            <i class="fas fa-caret-square-left fa-2x" style="color:#0675ad"></i>
        </a>
        <a class="carousel-control-next" href="#asd" role="button" data-slide="next">
          <i class="fas fa-caret-square-right fa-2x" style="color:#0675ad"></i>
        </a>
    </div>
  </header>