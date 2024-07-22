<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baza";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Neuspela konekcija: " . $conn->connect_error);
}

// Pie chart 1
$sql1 = "SELECT tip_smestaja, COUNT(*) as broj_soba FROM soba WHERE raspolozivost = 'dostupan' GROUP BY tip_smestaja";
$result1 = $conn->query($sql1);

$tipovi_soba1 = [];
$broj_soba = [];

while ($row1 = $result1->fetch_assoc()) {
    $tipovi_soba1[] = $row1['tip_smestaja'];
    $broj_soba[] = $row1['broj_soba'];
}

// Pie chart 2
$sql2 = "SELECT tip_smestaja, COUNT(*) as broj_rezervacija FROM rezervacija GROUP BY tip_smestaja";
$result2 = $conn->query($sql2);

$tipovi_soba2 = [];
$broj_rezervacija = [];

while ($row2 = $result2->fetch_assoc()) {
    $tipovi_soba2[] = $row2['tip_smestaja'];
    $broj_rezervacija[] = $row2['broj_rezervacija'];
}

 // Dodavanje sobe
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["broj_sobe"]) && isset($_POST["tip_smestaja"]) && isset($_POST["cena"]) && isset($_POST["raspolozivost"])) {
        $broj_sobe = $_POST["broj_sobe"];
        $tip_smestaja = $_POST["tip_smestaja"];
        $cena = $_POST["cena"];
        $raspolozivost = $_POST["raspolozivost"];

        $sql_check = "SELECT * FROM soba WHERE broj_sobe = '$broj_sobe'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
           $message = "Room with this number alredy exist.";
        } else {
            $sql = "INSERT INTO soba (broj_sobe, tip_smestaja, cena, raspolozivost) VALUES ('$broj_sobe', '$tip_smestaja', '$cena', '$raspolozivost')";

            if ($conn->query($sql) === TRUE) {
                $message = "New room successfully added.";
            } else {
                $message = "Error: " . $conn->error;
            }
        }
    }
}


 // Brisanje sobe
 if (isset($_POST["broj_sobe_brisanje"])) {
    $broj_sobe_brisanje = $_POST["broj_sobe_brisanje"];

    $sql_check = "SELECT * FROM soba WHERE broj_sobe = '$broj_sobe_brisanje'";
    $result = $conn->query($sql_check);

    if ($result->num_rows == 0) {
        $message = "Room with this number does not exist.";
    } else {
        $sql = "DELETE FROM soba WHERE broj_sobe = '$broj_sobe_brisanje'";

        if ($conn->query($sql) === TRUE) {
            $message = "Room successfully deleted.";
            
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Nove rezervacije
$sql = "SELECT * FROM rezervacija WHERE datum_odlaska >= CURDATE()";
$result = $conn->query($sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $rezervacija_id = $_POST['rezervacija_id'];
    $response = ['success' => false, 'message' => ''];

    if ($action == 'potvrdi') {
        $sql = "UPDATE rezervacija SET status = 'Prihvacena' WHERE rezervacija_id = $rezervacija_id";
        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Reservation confirmed successfully.';
        } else {
            $response['message'] = 'Error confirming reservation: ' . $conn->error;
        }
    } elseif ($action == 'obrisi') {
        $sql = "DELETE FROM rezervacija WHERE rezervacija_id = $rezervacija_id";
        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Reservation deleted successfully.';
        } else {
            $response['message'] = 'Error deleting reservation: ' . $conn->error;
        }
    }

    echo json_encode($response);
    exit;
}

$conn->close();
?>

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
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .charts-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .chart {
            flex: 1 1 45%;
            max-width: 45%;
            box-sizing: border-box;
            margin: 10px;
        }
        .chart canvas {
            display: block;
            margin: auto;
        }
        .chart h2 {
            text-align: center;
        }
    </style>
    <script>
        //Tabela sa novim rezervacijama
        function updateReservation(action, reservationId) {
            fetch('admin_panel.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'action': action,
                    'rezervacija_id': reservationId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('rezervacija_' + reservationId).remove();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the request.');
            });
        }
    </script>
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
    <h2 class="section-header" style="margin-top: 10px; margin-bottom: 0px;">ADMIN PANEL</h2>
    <h4 class="section-header"><i>(Room&Reservations management)</i></h4> <br>
    <div class="charts-container">
        <div class="chart">
            <h2>Pie Chart - Available Rooms</h2>
            <canvas id="pieChart1"></canvas>
        </div>
        <div class="chart">
            <h2>Pie Chart - Number of reservations </h2>
            <canvas id="pieChart2"></canvas>
        </div>
    </div>

    <!--Pie charts-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx1 = document.getElementById('pieChart1').getContext('2d');
        var pieChart1 = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($tipovi_soba1); ?>,
                datasets: [{
                    data: <?php echo json_encode($broj_soba); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            }
        });
    </script>
    <script>
        var ctx2 = document.getElementById('pieChart2').getContext('2d');
        var pieChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($tipovi_soba2); ?>,
                datasets: [{
                    data: <?php echo json_encode($broj_rezervacija); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            }
        });
    </script>

    <!--Dodavanje nove sobe-->
    <h4 style="margin-bottom: 7px; margin-left: 6%;">Add new room</h4>
    <div class="container">
        <form action="admin_panel.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="broj_sobe">Room Number:</label>
                    <input type="text" class="form-control" id="broj_sobe" name="broj_sobe" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="tip_smestaja">Room Type:</label>
                    <select class="custom-select" id="tip_smestaja" name="tip_smestaja">
                        <option value="standard_single">Standard Single</option>
                        <option value="standard_double">Standard Double</option>
                        <option value="premium_single">Premium Single</option>
                        <option value="silver_double">Silver Double</option>
                        <option value="premium_double">Premium Double</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="cena">Price for daily rent:</label>
                    <input type="text" class="form-control" id="cena" name="cena" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="raspolozivost">Availability:</label>
                    <select class="custom-select" id="raspolozivost" name="raspolozivost">
                        <option value="dostupan">Available</option>
                        <option value="zauzet">Not Available</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Add</button>
        </form>
    </div>

    <!--Brisanje sobe-->
    <h4 style="margin-left: 7%;">Delete room</h4>
    <div class="container">
        <form action="admin_panel.php" method="post">
            <div class="form-group col-md-6">
                <label for="broj_sobe_brisanje">Room Number:</label>
                <input type="text" class="form-control" id="broj_sobe_brisanje" name="broj_sobe_brisanje" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>

    <!--Nove rezervacije-->
    <h3 style="margin-left: 7%;">New reservations</h3>
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='container' style='width: 80%; margin: 0 auto;'>";
        echo "<table class='table table-striped' style='width: 90%; margin-left:7%;' >";
        echo "<thead class='thead-dark'>
                <tr>
                    <th>ID rezervacije</th>
                    <th>ID korisnika</th>
                    <th>Datum dolaska</th>
                    <th>Datum odlaska</th>
                    <th>Status</th>
                </tr>
              </thead>
              <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='rezervacija_{$row['rezervacija_id']}'>
                    <td>{$row['rezervacija_id']}</td>
                    <td>{$row['korisnik_id']}</td>
                    <td>{$row['datum_dolaska']}</td>
                    <td>{$row['datum_odlaska']}</td>
                    <td>
                        <button class='btn btn-success' onclick='updateReservation(\"potvrdi\", {$row['rezervacija_id']})'>Confirm</button>
                        <button class='btn btn-danger' onclick='updateReservation(\"obrisi\", {$row['rezervacija_id']})'>Delete</button>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No new reservations.";
    }
    ?>

        <a href="login.php" style="margin-left: 6%;" class="btn btn-danger"  >Log Out</a> 

        <div id="footer" style="margin-top: 20px;">
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
        
        <script src="js/booking.js"></script>
        <script src="js/jqBootstrapValidation.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

