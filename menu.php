<?php
    print '
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?menu=1"
                >Home <span class="sr-only">(current)</span></a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?menu=2">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?menu=3">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?menu=4">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?menu=5">Gallery</a>
            </li>
            </ul>
            <ul class="navbar-nav ml-auto">';
            if(!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false'){
                print '
                <li class="nav-item">
                <a class="nav-link" href="index.php?menu=6">Prijava</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="index.php?menu=7">Registracija</a>
                </li>';
            }
            else if ($_SESSION['user']['valid'] == 'true'){
                print '
                <li class="nav-item">
                <a class="nav-link" href="index.php?menu=8">Admin</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="signout.php">Odjava</a>
                </li>
                ';
            }
            print '
            <ul>
        </div>';
?>