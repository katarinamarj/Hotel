<?php

$localhost = "localhost";
$root = "root";
$sifra = "";
$baza = "baza";
$port = 3307;

$conn = new mysqli($localhost, $root, $sifra, $baza, $port);

if ($conn->connect_error) {
    die("Greška u povezivanju s bazom podataka: " . $conn->connect_error);
}

$tip_smestaja = $_POST['tip_smestaja'];

$upit = "SELECT s.tip_smestaja, COUNT(r.rezervacija_id) AS broj_rezervacija
         FROM rezervacija r
         JOIN soba s ON r.tip_smestaja = s.tip_smestaja
         WHERE s.tip_smestaja = ?
         GROUP BY s.tip_smestaja";

$stmt = $conn->prepare($upit);
$stmt->bind_param('s', $tip_smestaja);
$stmt->execute();

$result = $stmt->get_result();

$tipovi_smestaja = [];
$brojevi_rezervacija = [];

while ($row = $result->fetch_assoc()) {
    $tipovi_smestaja[] = $row['tip_smestaja'];
    $brojevi_rezervacija[] = (int)$row['broj_rezervacija'];
}

$stmt->close();
$conn->close();

$odgovor = [
    'tipovi_smestaja' => $tipovi_smestaja,
    'brojevi_rezervacija' => $brojevi_rezervacija
];

echo json_encode($odgovor);
?>
