<?php
	if (isset($_COOKIE['pl'])) {
		// CONNECTING TO THE DATABASE
		$connect = mysqli_connect('localhost', 'root', '', 'auth');
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		// CHECK IF COOKIE SELECTOR MATCHES ANYTHING IN DB
		$query = "SELECT * FROM `persistant_login` WHERE `Selector`='" . explode(":", $_COOKIE['pl'])[0] . "'";
		$result = mysqli_query($connect, $query);
		$row = mysqli_fetch_array($result);
		
		// CHECK IF QUERY RETURNED ANY ROWS
		if (count($row) > 0) {
			if ($row['Sess_Expire'] < time()) {
				unset($_COOKIE['pl']);
				setcookie('pl', '', time() - 3600);
				$query = "DELETE FROM `persistant_login` WHERE `Selector`='" . explode(":", $_COOKIE['pl'])[0] . "'";
				mysqli_query($connect, $query);
			} elseif (hash_equals($row['Sess_Token'], hash("sha256", explode(":", $_COOKIE['pl'])[1], true))) {
				$query = "SELECT * FROM `users` WHERE `User_ID`='" . $row['User_ID'] . "'";
				$result = mysqli_query($connect, $query);
				$row = mysqli_fetch_array($result);
				$_SESSION['id'] = $row['User_ID'];
				$_SESSION['user'] = $row['Username'];
				$_SESSION['email'] = $row['Email'];
				header("location: home.php");
			} else {
				unset($_COOKIE['pl']);
				setcookie('pl', '', time() - 3600);
			}
		} else {
			unset($_COOKIE['pl']);
			setcookie('pl', '', time() - 3600);
		}
	}
	
	if (!session_id()) {
		session_start();
		if (!isset($_SESSION['canary'])) {
			session_regenerate_id(true);
			$_SESSION['canary'] = time();
		}
	}
	
	if ($_SESSION['canary'] < time() - 300) {
		session_regenerate_id(true);
		$_SESSION['canary'] = time();
	}
	
	if (isset($_SESSION['user'])) {
		header("location: home.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Umich Squad Forum Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional Bootstrap theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	</head>
	<body>
		<!-- All page code goes in the page-content-wrapper -->
		<div id="page-content-wrapper">
			<div class="container-fluid" style="padding:0px 10px 0px 10px;">
				<div class="row" style="margin:20px 5px 15px 5px;padding-bottom:5px;background-color:#246C60;color:#222222;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h1>Home Page <small style="color:#333333;">for all of your rating & review needs</small></h1>
					</div>
				</div>
				<div class="row" style="margin:15px 5px 15px 5px;padding-bottom:5px;background-color:#2C4770;color:#222222;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h2 style="text-align:center;margin-bottom:15px;">Login</h1>
						<form class="form-horizontal" method="post" action="login.php">
							<div class="form-group">
								<label class="control-label col-sm-2" for="user">Username:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="user" name="user" placeholder="Enter username or email">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="password">Password:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<label><input type="checkbox" name="remember" value="on"> Stay Signed In</label>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default" name="login">Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row" style="margin:15px 5px 15px 5px;padding-bottom:5px;background-color:#152D54;color:#666666;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h2 style="text-align:center;"><a href="register.php">Register</a></h2>
					</div>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>