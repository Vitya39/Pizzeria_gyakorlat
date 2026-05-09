<?php
if (isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
    try {
        $dbh = dbconnect();
        $sqlSelect = "SELECT id, csaladi_nev, uto_nev FROM felhasznalok WHERE bejelentkezes = :bejelentkezes AND jelszo = SHA1(:jelszo)";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => $_POST['jelszo']));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $_SESSION['csn'] = $row['csaladi_nev'];
            $_SESSION['un'] = $row['uto_nev'];
            $_SESSION['login'] = $_POST['felhasznalo'];
            header('Location: .');
            exit;
        } else {
            $uzenet = 'Hibás felhasználónév vagy jelszó.';
        }
    } catch (PDOException $e) {
        $uzenet = 'Hiba: ' . $e->getMessage();
    }
} else {
    header('Location: .');
    exit;
}
?>
