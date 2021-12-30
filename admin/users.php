<?php 
	
	# Update user profile
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = "UPDATE korisnik SET Ime='" . $_POST['firstname'] . "', Prezime='" . $_POST['lastname'] . "', Username='" . $_POST['username'] . "', Drzava='" . $_POST['country'] . "', Rola='" . $_POST['rola'] . "' WHERE Email='" . $_POST['edit'] . "'";
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		# Close MySQL connection
		@mysqli_close($MySQL);
		
		$_SESSION['message'] = '<p>You successfully changed user profile!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End update user profile
	
	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM korisnik";
		$query .= " WHERE Email='".$_GET['delete']."'";
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>You successfully deleted user profile!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End delete user profile
	
	
	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM korisnik";
		$query .= " WHERE Email='".$_GET['id']."'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>User profile</h2>
		<p><b>First name:</b> ' . $row['Ime'] . '</p>
		<p><b>Last name:</b> ' . $row['Prezime'] . '</p>
		<p><b>Username:</b> ' . $row['Username'] . '</p>';
		$_query  = "SELECT * FROM drzave";
		$_query .= " WHERE country_code='" . $row['Drzava'] . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Country:</b> ' .$_row['country_name'] . '</p>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query = "SELECT * FROM korisnik WHERE Email='". $_GET['edit'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
	
		print '
		<h2>Edit user profile</h2>
		<form action="" id="registration_form" name="registration_form" method="POST">
        <div class="col-md-5">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<input class="form-control" type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="fname">First Name *</label>
			<input class="form-control" type="text" id="fname" name="firstname" value="' . $row['Ime'] . '" placeholder="Your name.." required>
			<label for="lname">Last Name *</label>
			<input class="form-control" type="text" id="lname" name="lastname" value="' . $row['Prezime'] . '" placeholder="Your last natme.." required>
            <label for="lname">Email adresa</label>
			<input class="form-control" type="text" id="email" name="email" value="' . $row['Email'] . '" placeholder="Email" disabled>
			<label for="username">Username *<small>(Username must have min 5 and max 10 char)</small></label>
			<input class="form-control" type="text" id="username" name="username" value="' . $row['Username'] . '" pattern=".{5,10}" placeholder="Username.." required>
			
			<label for="country">Country</label>
			<select class="form-control" name="country" id="country">
				<option value="">molimo odaberite</option>';
				#Select all countries from database webprog, table countries
				$_query  = "SELECT * FROM drzave";
				$_result = @mysqli_query($MySQL, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['country_code'] . '"';
					if ($row['Drzava'] == $_row['country_code']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
			</select>

			<label for="country">Country</label>
			<select class="form-control" name="rola" id="rola">
				<option value="0"'; if($row["Rola"] == 0) { print ' selected';} print '>Korisnik</option>
				<option value="2"'; if($row["Rola"] == 2) { print ' selected';} print '>Editor</option>
				<option value="3"'; if($row["Rola"] == 3) { print ' selected';} print '>Administrator</option>
			</select>
			<hr>
			
			<input class="btn btn-outline-success" type="submit" value="Submit">
            </div>
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	else {
		print '
		<h2>List of users</h2>
		<div id="users">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th>First name</th>
						<th>Last name</th>
						<th>E mail</th>
						<th>Država</th>
						<th>Rola</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM korisnik";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><strong>' . $row['Ime'] . '</strong></td>
						<td><strong>' . $row['Prezime'] . '</strong></td>
						<td>' . $row['Email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM drzave";
							$_query .= " WHERE country_code='" . $row['Drzava'] . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
						<td>
						';
							if($row["Rola"] == 0) { print 'Korisnik'; }
							else if($row["Rola"] == 2) { print 'Editor'; }
							else if($row["Rola"] == 3) { print 'Administrator'; }
                        print '</td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['Email']. '">Info</a>
                        <a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['Email']. '">Uredi</a>
                        <a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['Email']. '">Obriši</a></td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>