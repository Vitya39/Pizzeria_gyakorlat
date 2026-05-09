<section>
    <h2>Kapcsolat</h2>
    <p>Használja az alábbi űrlapot, hogy üzenetet küldjön az oldal tulajdonosának.</p>
    <?php if (isset($uploadMessage)) { ?><p class="notice"><?= htmlspecialchars($uploadMessage) ?></p><?php } ?>
    <form id="contact-form" action="kapcsolat" method="post" novalidate>
        <fieldset>
            <legend>Üzenet küldése</legend>
            <label>
                <span>Név</span>
                <input type="text" name="nev" value="<?= htmlspecialchars($formData['nev']) ?>" required>
            </label>
            <label>
                <span>E-mail cím</span>
                <input type="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" required>
            </label>
            <label>
                <span>Tárgy</span>
                <input type="text" name="targy" value="<?= htmlspecialchars($formData['targy']) ?>" required>
            </label>
            <label>
                <span>Üzenet</span>
                <textarea name="uzenet" rows="5" required><?= htmlspecialchars($formData['uzenet']) ?></textarea>
            </label>
            <input type="submit" value="Küldés">
        </fieldset>
    </form>
</section>
<script>
document.getElementById('contact-form').addEventListener('submit', function (event) {
    var form = event.target;
    var errors = [];
    if (!form.nev.value.trim()) {
        errors.push('A név megadása kötelező.');
    }
    if (!form.email.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(form.email.value)) {
        errors.push('Érvényes e-mail címet adjon meg.');
    }
    if (!form.targy.value.trim()) {
        errors.push('A tárgy megadása kötelező.');
    }
    if (!form.uzenet.value.trim()) {
        errors.push('Az üzenet mező nem lehet üres.');
    }
    if (errors.length) {
        event.preventDefault();
        alert(errors.join('\n'));
    }
});
</script>
