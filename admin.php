<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if($_SESSION['user']['role'] > 1){
			if (!isset($action)) { $action = 2; }
			print '
			<div class="container">
			<br>
			<h1>Administration</h1>
			<div id="admin">
				<ul>';
				if($_SESSION['user']['role'] == 3){
					print '<li><a href="index.php?menu=8&amp;action=1">Korisnici</a></li>';
					print '<li><a href="index.php?menu=8&amp;action=2">Vijesti</a></li>';
				}
				else {
					print '<li><a href="index.php?menu=8&amp;action=2">Vijesti</a></li>';
				}
				print '
				</ul>';
				
				# Admin
				if($_SESSION["user"]["role"] == 2){
					if($action == 1){
						$_SESSION["message"] = '<p>You dont have the rights to see this page</p>';
					}
					else if($action == 2){
						$_SESSION["message"] = "";
						include("admin/news.php");
					}
				}

				# Editor
				else if ($_SESSION["user"]["role"] == 3) { 
					if($action == 1){
						include("admin/users.php");
					}
					else if($action == 2){
						include("admin/news.php");
					}
				}
			print '
			</div></div>';
		}
		else {
			$_SESSION['message'] = '<p>You have no rights to visit this page.</p>';
			header("Location: index.php?menu=1");
		}
	}
	else {
		$_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
		header("Location: index.php?menu=6");
	}
?>