<?php 
	print '
    <div class="container">
    <br />
	<h1>Sign In form</h1>
    <hr />
	<div id="signin">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
        <div class="col-md-4">
		<form action="" name="myForm" id="myForm" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<label for="username">Username:*</label>
			<input class="form-control" type="text" id="username" name="username" value="" pattern=".{5,10}" required>
									
			<label for="password">Password:*</label>
			<input class="form-control" type="password" id="password" name="password" value="" pattern=".{4,}" required>
									
			<input type="submit" class="btn btn-outline-success mt-2" value="Submit">
		</form></div>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM korisnik";
		$query .= " WHERE Username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (password_verify($_POST['password'], $row['Lozinka'])) {
			$_SESSION['user']['valid'] = 'true';
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['firstname'] = $row['Ime'];
			$_SESSION['user']['lastname'] = $row['Prezime'];
			$_SESSION['user']['role'] = $row["Rola"];
			$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			# Redirect to admin website
			header("Location: index.php?menu=1");
		}
		
		# Bad username or password
		else {
            unset($_SESSION['user']);
			$_SESSION['message'] = '<p>You entered wrong email or password!</p>';
			header("Location: index.php?menu=6");
		}
	}
	print '
	</div></div>';
?>