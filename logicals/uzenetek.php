<?php
$messages = array();
if (isset($_SESSION['login'])) {
    $dbh = dbconnect();
    $stmt = $dbh->query('SELECT id, nev, email, targy, uzenet, felhasznalo, DATE_FORMAT(bekuldes, "%Y-%m-%d %H:%i:%s") AS bekuldes FROM uzenetek ORDER BY bekuldes DESC');
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>