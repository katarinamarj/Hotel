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
    </head>

    <body>
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
        
        <div class="container mt-5">
            <h2 class="mb-4">Hotel Booking Form</h2>
            <form action="process_booking.php" method="post">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="arrival_date">Check-in:</label>
                    <input type="date" class="form-control" id="arrival_date" name="arrival_date" required>
                </div>

                <div class="form-group">
                    <label for="departure_date">Check-out:</label>
                    <input type="date" class="form-control" id="departure_date" name="departure_date" required>
                </div>

                <div class="form-group">
                    <label for="room_type">Room Type:</label>
                    <select class="form-control" id="room_type" name="room_type" required>
                        <option value="standard_single">Standard Single</option>
                        <option value="standard_double">Standard Double</option>
                        <option value="premium_single">Premium Single</option>
                        <option value="silver_double">Silver Double</option>
                        <option value="premium_double">Premium Double</option>
                    </select>
                </div>

                <button type="submit" style="margin-top:10px; margin-bottom:15px;" class="btn btn-primary">Reserve</button>
                <a href="login.php" style="margin-top:10px; margin-bottom:15px;" class="btn btn-danger">Log out</a> 
            </form>
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
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/tempusdominus/js/moment.min.js"></script>
        <script src="vendor/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <script>
            $(document).ready(function() {
                var today = new Date().toISOString().split('T')[0];
                $('#arrival_date').attr('min', today);

                $('#arrival_date').on('change', function() {
                    var arrivalDate = $(this).val();
                    $('#departure_date').attr('min', arrivalDate);
                });

                $('#departure_date').on('change', function() {
                    var departureDate = $(this).val();
                    var arrivalDate = $('#arrival_date').val();
                    if (departureDate < arrivalDate) {
                        alert("Check-out date cannot be before check-in date.");
                        $(this).val('');
                    }
                });
            });
        </script>
        
        <script src="vendor/jquery/jquery-migrate.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/easing/easing.min.js"></script>
        <script src="vendor/stickyjs/sticky.js"></script>
        <script src="vendor/superfish/hoverIntent.js"></script>
        <script src="vendor/superfish/superfish.min.js"></script>
        <script src="vendor/wow/wow.min.js"></script>
        <script src="vendor/slick/slick.min.js"></script>
        <script src="vendor/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="vendor/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        
        <script src="js/booking.js"></script>
        <script src="js/jqBootstrapValidation.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
