<section>
    <h2>Belépés</h2>
    <?php if (isset($uzenet)) { ?><p class="notice"><?= htmlspecialchars($uzenet) ?></p><?php } ?>
    <form action="belep" method="post" autocomplete="off">
        <fieldset>
            <legend>Bejelentkezés</legend>
            <label>
                <span>Felhasználónév</span>
                <input type="text" name="felhasznalo" placeholder="felhasználó" value="<?= isset($_POST['felhasznalo']) ? htmlspecialchars($_POST['felhasznalo']) : '' ?>" required>
            </label>
            <label>
                <span>Jelszó</span>
                <input type="password" name="jelszo" placeholder="jelszó" required>
            </label>
            <input type="submit" name="belepes" value="Belépés">
        </fieldset>
    </form>
</section>
<section>
    <h2>Regisztráció</h2>
    <form action="regisztral" method="post" autocomplete="off">
        <fieldset>
            <legend>Új felhasználó</legend>
            <label>
                <span>Vezetéknév</span>
                <input type="text" name="vezeteknev" placeholder="vezetéknév" required>
            </label>
            <label>
                <span>Utónév</span>
                <input type="text" name="utonev" placeholder="utónév" required>
            </label>
            <label>
                <span>Felhasználói név</span>
                <input type="text" name="felhasznalo" placeholder="felhasználói név" required>
            </label>
            <label>
                <span>Jelszó</span>
                <input type="password" name="jelszo" placeholder="jelszó" required>
            </label>
            <input type="submit" name="regisztracio" value="Regisztráció">
        </fieldset>
    </form>
</section>
