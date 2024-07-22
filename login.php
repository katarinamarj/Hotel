<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "baza";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Neuspesna konekcija: " . $conn->connect_error);
}

function proveriLogin($korisnickoIme, $lozinka, $conn) {
    $sql = "SELECT * FROM korisnik WHERE korisnickoIme = '$korisnickoIme' AND lozinka = '$lozinka'";
    $rezultat = $conn->query($sql);

    if ($rezultat->num_rows == 1) {
        $korisnik = $rezultat->fetch_assoc();
        return $korisnik;
    } else {
        return false;
    }
}

function preusmeri($uloga) {
    switch ($uloga) {
        case 'gost':
            echo "Preusmeravanje na: booking_page.php";
            header("Location: booking_page.php");
            break;
        case 'administrator':
            echo "Preusmeravanje na: admin_panel.php";
            header("Location: admin_panel.php");
            break;
        default:
            echo "Neispravna uloga, preusmeravanje na: registracija.html";
            header("Location: registracija.html");
            break;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnickoIme = $_POST["korisnickoIme"];
    $lozinka = $_POST["lozinka"];

    $korisnik = proveriLogin($korisnickoIme, $lozinka, $conn);

    if ($korisnik) {
        preusmeri($korisnik['uloga']);
    } else {
        $message =  "Incorrect username or password!";
    }
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ROYAL HOTEL | Responsive Travel & Tourism Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link href="img/favicon.jpg" rel="icon">
        <link href="img/apple-favicon.png" rel="apple-touch-icon">

        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet"> 

        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="vendor/slick/slick.css" rel="stylesheet">
        <link href="vendor/slick/slick-theme.css" rel="stylesheet">
        <link href="vendor/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

        <link href="css/hover-style.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
                margin: 0;
            }

            .flex-container {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            #login {
                flex: 1;
            }

            #footer {
               
                padding: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class="flex-container">
            <header id="header">
                <a href="index.html" class="logo"><img src="img/logo.png" alt="logo"></a>
                <div class="phone"><i class="fa fa-phone"></i>+971 12-345-6789</div>
                <div class="mobile-menu-btn"><i class="fa fa-bars"></i></div>
                <nav class="main-menu top-menu">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="registration.php">Registration</a></li>
                    </ul>
                </nav>
            </header>
            <div id="login">
                <div class="container">
                    <div class="section-header">
                        <h2>Login</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="login-form">
                                <form method="post" action="login.php">
                                    <div class="form-row">
                                        <div class="control-group col-sm-6">
                                            <label>Username</label>
                                            <input type="text" class="form-control" id="korisnickoIme" name="korisnickoIme" required="required" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="control-group col-sm-6">
                                            <label>Your Password</label>
                                            <input type="password" class="form-control" id="lozinka" name="lozinka" required="required" />
                                        </div>
                                    </div>
                                    <div class="button"><button type="submit">Login</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="social">
                                <a href=""><li class="fa fa-instagram"></li></a>
                                <a href=""><li class="fa fa-twitter"></li></a>
                                <a href=""><li class="fa fa-facebook-f"></li></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <p>Copyright &#169; 2045 <a href="">Jumeirah - Burj Al Arab</a> All Rights Reserved.</p>
                            <p>Designed By <a href="https://htmlcodex.com">A & K Design</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/jquery/jquery-migrate.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/easing/easing.min.js"></script>
        <script src="vendor/stickyjs/sticky.js"></script>
        <script src="vendor/superfish/hoverIntent.js"></script>
        <script src="vendor/superfish/superfish.min.js"></script>
        <script src="vendor/wow/wow.min.js"></script>
        <script src="vendor/slick/slick.min.js"></script>
        <script src="vendor/tempusdominus/js/moment.min.js"></script>
        <script src="vendor/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="vendor/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="js/jqBootstrapValidation.min.js"></script>
        <script src="js/contact.js"></script>
        <script src="js/main.js"></script>

        <?php
        if (!empty($message)) {
            echo "<script>
                alert('$message');
            </script>";
        }
        ?>
    </body>
</html>

