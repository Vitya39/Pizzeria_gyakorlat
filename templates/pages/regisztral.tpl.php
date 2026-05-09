<section>
    <h2>Regisztráció eredménye</h2>
    <?php if (isset($uzenet)) { ?>
        <p class="notice"><?= $uzenet ?></p>
        <?php if ($ujra) { ?>
            <p><a href="belepes">Próbálja újra!</a></p>
        <?php } else { ?>
            <p><a href="belepes">Belépés</a></p>
        <?php } ?>
    <?php } ?>
</section>