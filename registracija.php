<?php 
	print '
    <div class="container">
    <br />
	<h1>Registration Form</h1>
    <hr />
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
        <div class="card mb-4" style="width: 30rem">
        <div class="card-body">
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
            <div class="row">
                <div class="col-md-6">
                    <label for="fname">First Name *</label>
                    <input class="form-control" type="text" id="fname" name="firstname" placeholder="Your name.." required>
                </div>
                <div class="col-md-6">
                    <label for="lname">Last Name *</label>
                    <input class="form-control" type="text" id="lname" name="lastname" placeholder="Your last natme.." required>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <label for="email">Your E-mail *</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Your e-mail.." required>
			</div></div>
            <div class="row">
            <div class="col-md-12">
			<label for="username">Username:* <small>(Username must have min 5 and max 10 char)</small></label>
			<input class="form-control" type="text" id="username" name="username" pattern=".{5,10}" placeholder="Username.." required>
			</div></div>
            <div class="row">
            <div class="col-md-12">
			<label for="password">Password:* <small>(Password must have min 4 char)</small></label>
			<input class="form-control" type="password" id="password" name="password" placeholder="Password.." pattern=".{4,}" required>
            </div></div>
            <div class="row">
            <div class="col-md-12">
			<label for="country">Country:</label>
			<select class="form-control" name="country" id="country">
				<option value="">Odaberite</option>';
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM drzave";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
				}
			print '
			</select></div></div>
            <div class="row mt-2">
            <div class="col-md-12">
			<input class="btn btn-outline-success" type="submit" value="Submit"></div></div>
		</form></div></div></div>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM korisnik";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if ($row['email'] == '' || $row['username'] == '') {
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO korisnik (Ime, Prezime, Email, Username, Lozinka, Drzava)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "')";
			$result = @mysqli_query($MySQL, $query);
			
			echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', thank you for registration </p>
			<hr>';
		}
		else {
			echo '<p>User with this email or username already exist!</p>';
		}
	}
	print '
	</div>';
?>