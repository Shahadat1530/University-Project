<?php include 'connection.php'; ?>
<?php 
    $t_id = isset($_GET['tId']) ? $_GET['tId'] : 0;
    $str = "DELETE from students WHERE id=$t_id";
    if(mysqli_query($con, $str)){
        header('Location: student.php');
    }
?>