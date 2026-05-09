<?php
$images = array();
$uploadMessage = '';
$flashKey = 'kepekMessage';
$uploadDir = __DIR__ . '/../images/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
if (!empty($_SESSION[$flashKey])) {
    $uploadMessage = $_SESSION[$flashKey];
    unset($_SESSION[$flashKey]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['login'])) {
    if (isset($_POST['delete_image'], $_POST['image_id'])) {
        $imageId = (int) $_POST['image_id'];
        $dbh = dbconnect();
        $stmt = $dbh->prepare('SELECT fajlnev, feltolto FROM kepek WHERE id = :id');
        $stmt->execute(array(':id' => $imageId));
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($image) {
            if ($image['feltolto'] !== $_SESSION['login']) {
                $_SESSION[$flashKey] = 'Csak a kép feltöltője törölheti ezt a képet.';
            } else {
                $filename = basename($image['fajlnev']);
                $filepath = $uploadDir . '/' . $filename;
                if (file_exists($filepath)) {
                    @unlink($filepath);
                }
                $stmt = $dbh->prepare('DELETE FROM kepek WHERE id = :id');
                $stmt->execute(array(':id' => $imageId));
                $_SESSION[$flashKey] = 'A kép sikeresen törölve.';
            }
        } else {
            $_SESSION[$flashKey] = 'A kiválasztott kép nem található.';
        }
        header('Location: kepek');
        exit;
    }

    if (isset($_FILES['kep'])) {
        $file = $_FILES['kep'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $allowed = array('image/jpeg', 'image/png', 'image/gif');
            if (in_array($file['type'], $allowed, true)) {
                $filename = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', basename($file['name']));
                $destination = $uploadDir . '/' . $filename;
                $unique = 1;
                while (file_exists($destination)) {
                    $destination = $uploadDir . '/' . pathinfo($filename, PATHINFO_FILENAME) . '-' . $unique . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                    $unique++;
                }
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $dbh = dbconnect();
                    $sql = 'INSERT INTO kepek (fajlnev, feltolto) VALUES (:fajlnev, :feltolto)';
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array(':fajlnev' => basename($destination), ':feltolto' => $_SESSION['login']));
                    $_SESSION[$flashKey] = 'A kép feltöltése sikeres.';
                } else {
                    $_SESSION[$flashKey] = 'A kép feltöltése sikertelen.';
                }
            } else {
                $_SESSION[$flashKey] = 'Csak JPG, PNG és GIF képek engedélyezettek.';
            }
        } else {
            $_SESSION[$flashKey] = 'Hiba történt a fájl feltöltésekor.';
        }
        header('Location: kepek');
        exit;
    }
}

$dbh = dbconnect();
$images = $dbh->query('SELECT * FROM kepek ORDER BY feltoltes DESC')->fetchAll(PDO::FETCH_ASSOC);
?>