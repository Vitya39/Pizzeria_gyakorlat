<?php
$crudMessage = '';
$editItem = null;
$dbh = dbconnect();

$categories = $dbh->query('SELECT nev, ar FROM pizza_categories ORDER BY nev ASC')->fetchAll(PDO::FETCH_ASSOC);
$categoryMap = array_column($categories, 'ar', 'nev');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cmd = $_POST['cmd'] ?? '';
    $nev = trim($_POST['nev'] ?? '');
    $leiras = trim($_POST['leiras'] ?? '');
    $kategoria = trim($_POST['kategoria'] ?? '');
    $vegetarianus = isset($_POST['vegetarianus']) ? 1 : 0;

    if ($nev === '') {
        $crudMessage = 'A pizza neve kötelező.';
    } elseif ($kategoria === '') {
        $crudMessage = 'A kategória kiválasztása kötelező.';
    } elseif (!isset($categoryMap[$kategoria])) {
        $crudMessage = 'A kiválasztott kategória nem létezik.';
    } else {
        if ($cmd === 'create') {
            $stmt = $dbh->prepare('INSERT INTO pizzas (nev, kategoria, vegetarianus, leiras) VALUES (:nev, :kategoria, :vegetarianus, :leiras)');
            $stmt->execute(array(
                ':nev' => $nev,
                ':kategoria' => $kategoria,
                ':vegetarianus' => $vegetarianus,
                ':leiras' => $leiras
            ));
            $crudMessage = 'Új pizza hozzáadva.';
        } elseif ($cmd === 'update' && isset($_POST['id'])) {
            $stmt = $dbh->prepare('UPDATE pizzas SET nev = :nev, kategoria = :kategoria, vegetarianus = :vegetarianus, leiras = :leiras WHERE id = :id');
            $stmt->execute(array(
                ':nev' => $nev,
                ':kategoria' => $kategoria,
                ':vegetarianus' => $vegetarianus,
                ':leiras' => $leiras,
                ':id' => (int)$_POST['id']
            ));
            $crudMessage = 'Pizza módosítása sikeres.';
        }
    }
}

$action = $_GET['action'] ?? '';
if ($action === 'delete' && isset($_GET['id'])) {
    $stmt = $dbh->prepare('DELETE FROM pizzas WHERE id = :id');
    $stmt->execute(array(':id' => (int)$_GET['id']));
    $crudMessage = 'Pizza törölve.';
    header('Location: crud');
    exit;
}

if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $dbh->prepare('SELECT * FROM pizzas WHERE id = :id');
    $stmt->execute(array(':id' => (int)$_GET['id']));
    $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
}

$items = $dbh->query('SELECT p.*, c.ar AS category_price FROM pizzas p LEFT JOIN pizza_categories c ON p.kategoria = c.nev ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>