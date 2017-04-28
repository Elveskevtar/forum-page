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
		<div id="page-content-wrapper">
			<!-- All page code goes in the page-content-wrapper -->
			<?php
				// DATABASE INFORMATION
				$server = 'localhost';
				$database = 'auth';
				$dbuser = 'root';
				$dbpassword = '';
				
				// CONNECTING TO THE DATABASE
				$connect = mysqli_connect($server, $dbuser, $dbpassword, $database);
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				
				// ESCAPE STRING WHEN RECEIVED FROM USERS
				$safe_username = mysqli_real_escape_string($connect, "Elveskevtar");
				$safe_password = mysqli_real_escape_string($connect, "West7572");
				
				// QUERY
				$query = "SELECT * FROM `users` WHERE `Username`='" . $safe_username . "'";
				$result = mysqli_query($connect, $query);
				$row = mysqli_fetch_array($result);
				
				// CHECK QUERY AGAINST PASSWORD
				if (password_verify("West7572", $row['Password'])) {
					echo "PASSWORD VERIFIED";
				} else {
					echo "PASSWORD DENIED";
				}
				
				/*$timeTarget = 0.1; // 100 milliseconds
				$cost = 8;
				do {
					$cost++;
					$start = microtime(true);
					$passHash = password_hash($dbpassword, PASSWORD_DEFAULT, ["cost" => $cost]);
					$end = microtime(true);
					$timeElapsed = $end - $start;
				} while ($timeElapsed < $timeTarget);
				echo "Appropriate Cost Found: " . $cost . " in " . $timeElapsed . "ms\nHashed Password: " . $passHash;
				if (password_verify($dbpassword, $passHash)) {
					echo "PASSWORD VERIFIED";
				} else {
					echo "PASSWORD DENIED";
				}
				echo $passHash;*/
			?>
			
			
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>