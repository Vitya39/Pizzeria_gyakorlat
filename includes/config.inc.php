<?php
$ablakcim = array(
    'cim' => 'Pizneria.',
);

$fejlec = array(
    'kepforras' => 'logo.png',
    'kepalt' => 'logo',
    'cim' => 'WEB Programozás Gyakorlat Projekt',
    'motto' => 'Fedezd fel a legjobb pizzázót és webfejlesztési projekteket!'
);

$lablec = array(
    'copyright' => 'Copyright '.date("Y").' - Butor Bence (HMIK2Y), Nagy Viktor (D7GZCG)',
    'ceg' => 'Piznéria.'
);

$dbConfig = array(
    'host' => 'localhost',
    'dbname' => 'login',
    'user' => 'login',
    'pass' => 'asdasd'
);

$oldalak = array(
    '/' => array('fajl' => 'home', 'szoveg' => 'Főoldal', 'menun' => array(1,1)),
    'kepek' => array('fajl' => 'kepek', 'szoveg' => 'Képek', 'menun' => array(1,1)),
    'kapcsolat' => array('fajl' => 'kapcsolat', 'szoveg' => 'Kapcsolat', 'menun' => array(1,1)),
    'crud' => array('fajl' => 'crud', 'szoveg' => 'CRUD', 'menun' => array(1,1)),
    'uzenetek' => array('fajl' => 'uzenetek', 'szoveg' => 'Üzenetek', 'menun' => array(0,1)),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Belépés', 'menun' => array(1,0)),
    'kilepes' => array('fajl' => 'kilepes', 'szoveg' => 'Kilépés', 'menun' => array(0,1)),
    'belep' => array('fajl' => 'belep', 'szoveg' => '', 'menun' => array(0,0)),
    'regisztral' => array('fajl' => 'regisztral', 'szoveg' => '', 'menun' => array(0,0)),
    'bemutatkozas' => array('fajl' => 'bemutatkozas', 'szoveg' => 'Bemutatkozás', 'menun' => array(0,0)),
    'tablazat' => array('fajl' => 'tablazat', 'szoveg' => 'Táblázat', 'menun' => array(0,0))
);

$hiba_oldal = array('fajl' => '404', 'szoveg' => 'A keresett oldal nem található!');

function dbconnect() {
    global $dbConfig;
    static $dbh = null;
    if ($dbh === null) {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $dbConfig['host'], $dbConfig['dbname']);
        $dbh = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $dbh->exec("SET NAMES utf8 COLLATE utf8_hungarian_ci");

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS felhasznalok (
                id INT AUTO_INCREMENT PRIMARY KEY,
                csaladi_nev VARCHAR(100) NOT NULL,
                uto_nev VARCHAR(100) NOT NULL,
                bejelentkezes VARCHAR(100) NOT NULL UNIQUE,
                jelszo CHAR(40) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS uzenetek (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nev VARCHAR(200) NOT NULL,
                email VARCHAR(200) NOT NULL,
                targy VARCHAR(200) NOT NULL,
                uzenet TEXT NOT NULL,
                felhasznalo VARCHAR(100) DEFAULT NULL,
                bekuldes DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS kepek (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fajlnev VARCHAR(255) NOT NULL,
                feltolto VARCHAR(100) DEFAULT NULL,
                feltoltes DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS crud_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cim VARCHAR(150) NOT NULL,
                leiras TEXT NULL,
                ar DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                letrehozas DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS pizza_categories (
                nev VARCHAR(100) NOT NULL PRIMARY KEY,
                ar INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $dbh->exec(
            "CREATE TABLE IF NOT EXISTS pizzas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nev VARCHAR(150) NOT NULL,
                kategoria VARCHAR(100) NOT NULL,
                vegetarianus TINYINT(1) NOT NULL DEFAULT 0,
                leiras TEXT NULL,
                letrehozas DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (kategoria) REFERENCES pizza_categories(nev)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci"
        );

        $pizzaColumns = $dbh->query("SHOW COLUMNS FROM pizzas LIKE 'leiras'")->fetch(PDO::FETCH_ASSOC);
        if (!$pizzaColumns) {
            $dbh->exec("ALTER TABLE pizzas ADD COLUMN leiras TEXT NULL");
        }

        $pizzaCategoryColumns = $dbh->query("SHOW COLUMNS FROM pizzas LIKE 'kategoria'")->fetch(PDO::FETCH_ASSOC);
        if (!$pizzaCategoryColumns) {
            $dbh->exec("ALTER TABLE pizzas ADD COLUMN kategoria VARCHAR(100) NOT NULL");
        }

        $pizzaVegetarianusColumns = $dbh->query("SHOW COLUMNS FROM pizzas LIKE 'vegetarianus'")->fetch(PDO::FETCH_ASSOC);
        if (!$pizzaVegetarianusColumns) {
            $dbh->exec("ALTER TABLE pizzas ADD COLUMN vegetarianus TINYINT(1) NOT NULL DEFAULT 0");
        }
    }
    return $dbh;
}
?>