<?php
include'session.php';
session::init();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Login Register</title>
</head>
<?php
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        session::destroy();
    }
?>

<body>
    <section>
        <nav class="navbar navbar-dark bg-primary text-light navbar-expand">
            <!--expand korle left to right hobe r hosse link sign chole jabe-->
            <div class="container text-light">
                <a class="navbar-brand" href="index.php">Login Register System</a>
                <!--brand korle navbar lekha ta boro hoa jbe ektu-->
                <ul class="navbar-nav">
                    <?php
                    $id = session::get('id');
                    $userlogin = session::get('login');
                    if($userlogin==true)
                    {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="?action=logout" class="nav-link">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php?id=<?php echo $id;?>">Profile</a>
                    </li>
                    <?php
                    } else{
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="verify.php">Verify</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </section>
