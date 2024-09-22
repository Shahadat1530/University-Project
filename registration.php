<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Registration Form</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				background-color: #f3f3f3;
				margin: 0;
				padding: 0;
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100vh;
			}

			.main {
				background-color: #fff;
				border-radius: 15px;
				box-shadow: 0 0 20px
					rgba(0, 0, 0, 0.2);
				padding: 20px;
				width: 300px;
			}

			.main h2 {
				color: #4caf50;
				margin-bottom: 20px;
			}

			label {
				display: block;
				margin-bottom: 5px;
				color: #555;
				font-weight: bold;
			}

			input[type="text"],
			input[type="email"],
			input[type="password"],
			select {
				width: 100%;
				margin-bottom: 15px;
				padding: 10px;
				box-sizing: border-box;
				border: 1px solid #ddd;
				border-radius: 5px;
			}

			button[type="submit"] {
				padding: 15px;
				border-radius: 10px;
				border: none;
				background-color: #4caf50;
				color: white;
				cursor: pointer;
				width: 100%;
				font-size: 16px;
			}
		</style>
	</head>

	<body>
		<div class="main">
			<h2>Registration Form</h2>
			<form action="" method="post">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" required/>
				<label for="stid">Student Id</label>
				<input type="text" id="stid" name="stid" required/>
				<label for="password" >Password</label>
				<input type="password" id="password" name="password" title="Password must contain at least 6 characters long" required/>
				<label for="repassword">Re-type Password</label>
				<input type="password" id="repassword" name="repassword" required/>
				<button type="submit" name="submit">Submit</button>
			</form>            
		</div>
	</body>
</html>
<?php 
include 'connection.php';
    if(isset($_POST['submit'])){
        $name = $_POST["name"];
        $stid = $_POST["stid"];
        $password = $_POST["password"];
        $cnf_password = $_POST["repassword"];
        if($password == $cnf_password){
            $str = "INSERT INTO students(name, stid, password)
            VALUES 
            ('".$name."', '".$stid."', '".$password."')";
            if(mysqli_query($con, $str)){
                header('Location: login.php');
            }
        }
        else {
            echo 'Password Mismatch';
        }       
    }
?>