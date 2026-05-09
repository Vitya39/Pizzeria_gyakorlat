<?php
$formData = array('nev' => '', 'email' => '', 'targy' => '', 'uzenet' => '');
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['nev'] = trim($_POST['nev'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['targy'] = trim($_POST['targy'] ?? '');
    $formData['uzenet'] = trim($_POST['uzenet'] ?? '');

    if ($formData['nev'] === '') {
        $errors[] = 'A név megadása kötelező.';
    }
    if ($formData['email'] === '' || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Érvényes e-mail cím szükséges.';
    }
    if ($formData['targy'] === '') {
        $errors[] = 'A tárgy megadása kötelező.';
    }
    if ($formData['uzenet'] === '') {
        $errors[] = 'Az üzenet mezőt nem hagyhatja üresen.';
    }

    if (empty($errors)) {
        try {
            $dbh = dbconnect();
            $sql = 'INSERT INTO uzenetek (nev, email, targy, uzenet, felhasznalo) VALUES (:nev, :email, :targy, :uzenet, :felhasznalo)';
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':nev' => $formData['nev'],
                ':email' => $formData['email'],
                ':targy' => $formData['targy'],
                ':uzenet' => $formData['uzenet'],
                ':felhasznalo' => $_SESSION['login'] ?? null
            ));
            $uploadMessage = 'Az üzenet sikeresen elküldve.';
            $formData = array('nev' => '', 'email' => '', 'targy' => '', 'uzenet' => '');
        } catch (PDOException $e) {
            $uploadMessage = 'Hiba történt az üzenet mentésekor: ' . $e->getMessage();
        }
    } else {
        $uploadMessage = implode(' ', $errors);
    }
}
?>
