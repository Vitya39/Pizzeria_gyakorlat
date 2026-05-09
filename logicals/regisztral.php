<?php
if (isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['utonev'])) {
    try {
        $dbh = dbconnect();
        $sqlSelect = 'SELECT id FROM felhasznalok WHERE bejelentkezes = :bejelentkezes';
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));
        if ($sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = 'A felhasználói név már foglalt!';
            $ujra = true;
        } else {
            $sqlInsert = 'INSERT INTO felhasznalok (csaladi_nev, uto_nev, bejelentkezes, jelszo) VALUES (:csaladinev, :utonev, :bejelentkezes, :jelszo)';
            $stmt = $dbh->prepare($sqlInsert);
            $stmt->execute(array(
                ':csaladinev' => $_POST['vezeteknev'],
                ':utonev' => $_POST['utonev'],
                ':bejelentkezes' => $_POST['felhasznalo'],
                ':jelszo' => sha1($_POST['jelszo'])
            ));
            if ($stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztrációja sikeres. Azonosítója: {$newid}";
                $ujra = false;
            } else {
                $uzenet = 'A regisztráció nem sikerült.';
                $ujra = true;
            }
        }
    } catch (PDOException $e) {
        $uzenet = 'Hiba: ' . $e->getMessage();
        $ujra = true;
    }
} else {
    header('Location: .');
    exit;
}
?>