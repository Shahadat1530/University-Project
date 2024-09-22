<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #f4f4f4;
            color: #000;       
            padding: 19px;
           
        }

        .navbar a {
           
            color: #333;
            padding: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #ddd;
        }
        .navbar h3 {
            text-align: center;
        }

        .content {
            margin-left: 15px;
            
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #fff; 
            color: #000; 
        }

        thead th,
        tbody td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd; 
        }

        tbody tr:hover {
            background-color: #f0f0f0; 
        }
        table {
        width: 100%;
        border-collapse: collapse;
        }

        thead th,
        tbody td {
            padding: 10px;
            text-align: left;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd; 
            border-right: 1px solid #ddd; 
        }

        thead th:first-child,
        tbody td:first-child {
            border-left: 1px solid #ddd; 
        }

    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="dashboard.php">Comment Box</a>
    <a href="student.php">Students</a>
    <a href="logout.php">Logout</a>
</div>



<!-- Content area -->
<div class="content">
    <h2>Admin Dashboard</h2>
    <h4>Students</h4>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Student ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include 'connection.php';
            $sql = "SELECT * FROM students";
            $result = mysqli_query($con,$sql);
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['stid']; ?></td>
                <td>
                    <button onclick="confirmDelete(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>')">Delete</button>
                </td>        
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
  function confirmDelete(userId,username) {
        
        var confirmDelete = confirm("Are you sure you want to delete " + username + "?");

        
        if (confirmDelete) {
            
            window.location.href = 'delete.php?tId=' + userId;
        }
    }
    $(document).ready(function () {
    $("#example").DataTable({
        lengthMenu: [7], // Set the default page length to 7
        paging: true // Enable pagination
    });
    });
</script>
</body>
</html>
