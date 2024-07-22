<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "baza";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = isset($_POST["ime"]) ? $_POST["ime"] : '';
    $prezime = isset($_POST["prezime"]) ? $_POST["prezime"] : '';
    $korisnickoIme = isset($_POST["korisnickoIme"]) ? $_POST["korisnickoIme"] : '';
    $lozinka = isset($_POST["lozinka"]) ? $_POST["lozinka"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $telefon = isset($_POST["telefon"]) ? $_POST["telefon"] : '';

    $uloga = 'gost';

    
    $sql_check = "SELECT * FROM korisnik WHERE korisnickoIme = '$korisnickoIme'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        $message = "Username already exists. Please choose another one.";
    } else {
        $sql = "INSERT INTO korisnik (ime, prezime, korisnickoIme, lozinka, email, uloga, telefon) VALUES ('$ime', '$prezime', '$korisnickoIme', '$lozinka', '$email', '$uloga', '$telefon')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful";
            $redirect = true;
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
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

    <script src="registracija.js" defer></script>

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
</head>
<body>
    <header id="header">
        <a href="index.html" class="logo"><img src="img/logo.png" alt="logo"></a>
        <div class="phone"><i class="fa fa-phone"></i>+971 12-345-6789</div>
        <div class="mobile-menu-btn"><i class="fa fa-bars"></i></div>
        <nav class="main-menu top-menu">
        <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <div id="login">
        <div class="container">
            <div class="section-header">
                <h2>Registration</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="login-form">
                        <form method="POST" action="registration.php" onsubmit="return validateForm();">
                            <div class="form-row">
                                <div class="control-group col-sm-6">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="ime" id="ime" required />
                                </div>
                                <div class="control-group col-sm-6">
                                    <label>Surname:</label>
                                    <input type="text" class="form-control" name="prezime" id="prezime" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="control-group col-sm-6">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="korisnickoIme" id="korisnickoIme" required />
                                </div>
                                <div class="control-group col-sm-6">
                                    <label>Password:</label>
                                    <input type="password" class="form-control" name="lozinka" id="lozinka" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="control-group col-sm-6">
                                    <label>E-mail:</label>
                                    <input type="text" class="form-control" name="email" id="email" required />
                                </div>
                                <div class="control-group col-sm-6">
                                    <label>Phone:</label>
                                    <input type="tel" class="form-control" name="telefon" id="telefon" required />
                                </div>
                            </div>
                            <button type="submit">Registration</button>
                        </form>
                        <div id="error-message" style="color: red; margin-top: 10px;"></div>
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

    <script>
        function validateForm() {
            const ime = document.getElementById('ime').value;
            const prezime = document.getElementById('prezime').value;
            const korisnickoIme = document.getElementById('korisnickoIme').value;
            const lozinka = document.getElementById('lozinka').value;
            const email = document.getElementById('email').value;
            const telefon = document.getElementById('telefon').value;

            let errorMessage = '';

            if (!isValidName(ime)) {
                errorMessage += 'Enter a valid name.\n';
            }
            if (!isValidName(prezime)) {
                errorMessage += 'Enter a valid phone surname.\n';
            }
            if (!isValidUsername(korisnickoIme)) {
                errorMessage += 'Username must be 2-15 characters long.\n';
            }
            if (!isValidPassword(lozinka)) {
                errorMessage += 'Password must have 5 characters at least.\n';
            }
            if (!isValidEmail(email)) {
                errorMessage += 'Invalid email format.\n';
            }
            if (!isValidPhone(telefon)) {
                errorMessage += 'Enter a valid phone number.\n';
            }

            if (errorMessage) {
                document.getElementById('error-message').innerText = errorMessage;
                return false;
            }
            return true;
        }

        function isValidName(name) {
            const nameRegex = /^[a-zA-Z]{2,}$/;
            return nameRegex.test(name);
        }

        function isValidUsername(username) {
            const usernameRegex = /^[a-zA-Z0-9_]{2,}$/; 
            return usernameRegex.test(username);
        }

        function isValidPassword(password) {
            const passwordRegex = /^[a-zA-Z0-9]{5,}$/;
            return passwordRegex.test(password);
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^\d{5,}$/;
            return phoneRegex.test(phone);
        }
    </script>

    <?php
    if (!empty($message)) {
        echo "<script>
            alert('$message');
            " . ($redirect ? "window.location.href = 'login.php';" : "") . "
        </script>";
    }
    ?>
</body>
</html>