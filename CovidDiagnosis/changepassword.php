<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Covid Prediction Website</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
<script src="https://kit.fontawesome.com/8415f96b30.js" crossorigin="anonymous"></script>

</head>
<body>

<?php

include 'dbconnection.php';

if(isset($_GET['email']) && isset($_GET['reset_token']))
{
    date_default_timezone_set('Australia/Melbourne');
    $date=date("Y-m-d");
    $query="SELECT * from `registration` WHERE `email`='$_GET[email]' AND `token`='$_GET[reset_token]' AND `tokenexpiry`='$date'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            echo"<form method='POST'>
            <h1>Enter your New Password</h1>
            <input type='password' placeholder='New Password' name='Password'>
            <button type='submit' name='updatepassword'>Update</button>
            <input type='hidden' name='email' value='$_GET[email]'>
            </form>";

        }else{
            echo "<script>alert('Invalid or expired link')</script>";
        }
    }
    else{
        echo "<script>alert('Something went wrong')</script>";
    }
}

?>

<?php

if(isset($_POST['updatepassword'])){
    $pass=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $update="UPDATE `registration` SET `password`='$pass',`token`= NULL,`tokenexpiry`= NULL WHERE `email`='$_POST[email]'";
    if(mysqli_query($con,$update))
    {
        echo "<script>alert('Password Successfully Updated')</script>";

    }else{
        echo "<script>alert('Something went wrong')</script>";

    }
}


?>

</body>
</html>