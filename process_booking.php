<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ROYAL HOTEL</title>
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

            #content {
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
                    </ul>
                </nav>
            </header>
            <div id="content">
                
                <?php
                    
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "baza";
                    $port = 3307;

                    $conn = new mysqli($servername, $username, $password, $dbname, $port);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $arrival_date = $_POST['arrival_date'];
                    $departure_date = $_POST['departure_date'];
                    $room_type = $_POST['room_type'];
                    $username = $_POST['username'];

                    $result = $conn->query("SELECT korisnik_id FROM korisnik WHERE korisnickoIme = '$username'");

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $korisnik_id = $row['korisnik_id'];
                    } else {
                        $message = "The user with this username does not exist.";
                        $conn->close();
                        exit;
                    }

                    $sql = "INSERT INTO rezervacija (korisnik_id, datum_dolaska, datum_odlaska, tip_smestaja)
                            VALUES ('$korisnik_id', '$arrival_date', '$departure_date', '$room_type')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['arrival_date'] = $arrival_date;
                        $_SESSION['departure_date'] = $departure_date;
                        $_SESSION['room_type'] = $room_type;
                        $_SESSION['username'] = $username;

                        echo "<h2 class='mb-4' style='margin-left: 20px; margin-top: 40px'>Reservation confirmation</h2>";
                        echo "<p style='margin-left: 20px;'><strong>Check-in:</strong> $arrival_date</p>";
                        echo "<p style='margin-left: 20px;'><strong>Check-out:</strong> $departure_date</p>";
                        echo "<p style='margin-left: 20px;'><strong>Room Type:</strong> $room_type</p>";

                        echo '<a href="index.html" class="btn btn-secondary mt-3" style="margin-left: 20px; margin-bottom: 25px">Back on Home Page</a>';
                        echo '<a href="index.html#rooms" class="btn btn-primary mt-3" style="margin-left: 20px; margin-bottom: 25px">See Rooms</a>';
                        echo '<a href="login.php" style="margin-bottom: 25px" class="btn btn-danger mt-3 ml-3">Log Out</a>';
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $conn->close();
                ?>
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
        <script src="js/booking.js"></script>
        <script src="js/jqBootstrapValidation.min.js"></script>
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
