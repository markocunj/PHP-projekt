<?php
define('__APP__', TRUE);  
// error_reporting(E_ERROR | E_PARSE);
  include ("dbconn.php");
  session_start();
  	# Variables MUST BE INTEGERS
    if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
	if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
	
	# Variables MUST BE STRINGS A-Z
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
	
	if (!isset($menu)) { $menu = 1; }
	
	# Classes & Functions
  include_once("functions.php");
print '
<!DOCTYPE html>
<html>
  <head>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"> </script>  
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">  
    <title>AstroFun</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="style.css" />
    <meta name="author" content="Marko Cunj" />
    <meta
      name="viewport"
      content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"
    />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php?menu=1">AstroFun</a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">';
        include("menu.php");
        print '</div>
        </div>
      </nav>';
      if (isset($_SESSION['message'])) {
        print $_SESSION['message'];
        unset($_SESSION['message']);
      }
      if ($_GET['menu'] < 2) 
      {
        print '
        <div class="jumbotron text-center">
        <div class="hero-image"></div>
        </div>';
      }
      print '
    </header>
    <main>';
    	# Homepage
      if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
      
      # News
      else if ($_GET['menu'] == 2) { include("news.php"); }
      
      # Contact
      else if ($_GET['menu'] == 3) { include("contact.php"); }
      
      # About us
      else if ($_GET['menu'] == 4) { include("about.php"); }
      
      # Gallery
      else if ($_GET['menu'] == 5) { include("gallery.php"); }

      # Login
      else if ($_GET['menu'] == 6) { include("prijava.php"); }

      # Register
      else if ($_GET['menu'] == 7) { include("registracija.php"); }

      # Admin
      else if ($_GET['menu'] == 8) { include("admin.php"); }

      if ($_GET['menu'] != 6 && $_GET['menu'] != 7 && $_GET['menu'] != 8) {
        print '
          </main>
          <footer>
            <p>
              Copyright &copy; 2021. Marko Cunj
              <a href="https://github.com/markocunj/PHP-projekt"
                ><img src="img/GitHub-Mark-Light-32px.png" title="Github" alt="Github"
              /></a>
            </p>
          </footer>
        </body>
      </html>';
    }
?>
