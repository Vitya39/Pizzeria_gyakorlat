<?php if(file_exists('./logicals/'.$keres['fajl'].'.php')) { include("./logicals/{$keres['fajl']}.php"); } ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($ablakcim['cim']) ?></title>
    <link rel="stylesheet" href="./styles/stilus.css" type="text/css">
    <?php if(file_exists('./styles/'.$keres['fajl'].'.css')) { ?><link rel="stylesheet" href="./styles/<?= $keres['fajl']?>.css" type="text/css"><?php } ?>
</head>
<body>
    <header>
        <div class="brand">
            <img src="./images/<?=$fejlec['kepforras']?>" alt="<?=$fejlec['kepalt']?>">
            <div>
                <h1><?= $fejlec['cim'] ?></h1>
            </div>
        </div>
        <div class="user-info">
            <?php if(isset($_SESSION['login'])) { ?>Bejelentkezett: <strong><?= htmlspecialchars($_SESSION['csn'].' '.$_SESSION['un'].' ('.$_SESSION['login'].')') ?></strong><?php } ?>
        </div>
        <nav>
            <ul>
                <?php foreach ($oldalak as $url => $menuItem) { ?>
                    <?php if((!isset($_SESSION['login']) && $menuItem['menun'][0]) || (isset($_SESSION['login']) && $menuItem['menun'][1])) { ?>
                        <li<?= ($url === $oldal ? ' class="active"' : '') ?>>
                            <a href="<?= ($url == '/') ? '.' : $url ?>"><?= $menuItem['szoveg'] ?></a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </header>
    <main id="content">
        <?php include("./templates/pages/{$keres['fajl']}.tpl.php"); ?>
    </main>
    <footer>
        <?php if(isset($lablec['copyright'])) { ?>&copy;&nbsp;<?= $lablec['copyright'] ?> <?php } ?>
        <?php if(isset($lablec['ceg'])) { ?><?= $lablec['ceg']; ?><?php } ?>
    </footer>
</body>
</html>
