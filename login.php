<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: sans-serif;
            line-height: 1.5;
            min-height: 100vh;
            background: #f3f3f3;
            flex-direction: column;
            margin: 0;
        }

        .main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 10px 20px;
            transition: transform 0.2s;
            width: 500px;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
        }

        label {
            display: block;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 5px;
            text-align: left;
            color: #555;
            font-weight: bold;
        }

        input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            margin-bottom: 15px;
            border: none;
            color: white;
            cursor: pointer;
            background-color: #4CAF50;
            width: 100%;
            font-size: 16px;
        }

        .wrap {
            display: flex;
            justify-content: center;
            align-items: center;
        }

    </style>
</head>
<body>
<div class="main">
    <form action="" method="post">
        <label for="stid">Student ID</label>
        <input type="text" id="stid" name="stid" placeholder="Enter your ID" required>
        <label for="password"> Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your Password" required>
        <div class="wrap">
            <button type="submit" name="submit"> Login </button>
        </div>
    </form>
    <?php
    include 'connection.php';
    if(isset($_POST['submit'])){
        $stid = $_POST['stid'];
        $pswd = $_POST['password'];

        $query = "SELECT * FROM admin WHERE tid='$stid' AND password='$pswd' ";
        $result = mysqli_query($con,$query);
        $admin = mysqli_fetch_array($result);

        $query = "SELECT * FROM students WHERE stid='$stid' AND password='$pswd' ";
        $result = mysqli_query($con,$query);
        $user = mysqli_fetch_array($result);

        if($admin){
            $_SESSION['user'] = 'admin';
            $_SESSION['id'] = $admin['id'];
            header("Location: dashboard.php");
            exit(); 
        }
        else if($user){
            $_SESSION['user'] = 'student';
            $_SESSION['id'] = $user['id'];
            header("Location: index.html");
            exit(); 
        }
        else{
            echo "<span class='text-center text-danger' >Invalid Student ID or Password!</span>";
        }
    }
    ?>
    <p>Not registered? 
        <a href="registration.php" style="text-decoration: none;"> Create an account</a>
    </p>
</div>
</body>
</html>
