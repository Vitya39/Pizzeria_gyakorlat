<?php
$categories = isset($categories) ? $categories : array();
$items = isset($items) ? $items : array();
?>

<section>
    <h2>Pizzák kezelése</h2>
    <?php if (isset($crudMessage)) { ?><p class="notice"><?= htmlspecialchars($crudMessage) ?></p><?php } ?>

    <div class="crud-form">
        <form action="crud<?= isset($editItem) ? '?action=edit&id='.$editItem['id'] : '' ?>" method="post">
            <fieldset>
                <legend><?= isset($editItem) ? 'Pizza módosítása' : 'Új pizza hozzáadása' ?></legend>
                <label>
                    <span>Pizza neve</span>
                    <input type="text" name="nev" value="<?= isset($editItem['nev']) ? htmlspecialchars($editItem['nev']) : '' ?>" required>
                </label>
                <label>
                    <span>Kategória</span>
                    <select name="kategoria" required>
                        <option value="">Válassz kategóriát</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= htmlspecialchars($category['nev']) ?>" <?= isset($editItem['kategoria']) && $editItem['kategoria'] === $category['nev'] ? 'selected' : '' ?>><?= htmlspecialchars($category['nev']) ?> (<?= htmlspecialchars($category['ar']) ?> Ft)</option>
                        <?php } ?>
                    </select>
                </label>
                <label>
                    <span>Vegetáriánus</span>
                    <input type="checkbox" name="vegetarianus" value="1" <?= isset($editItem['vegetarianus']) && $editItem['vegetarianus'] ? 'checked' : '' ?> >
                </label>
                <?php if (isset($editItem)) { ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editItem['id']) ?>">
                    <input type="hidden" name="cmd" value="update">
                    <input type="submit" value="Módosít">
                <?php } else { ?>
                    <input type="hidden" name="cmd" value="create">
                    <input type="submit" value="Mentés">
                <?php } ?>
            </fieldset>
        </form>
    </div>

    <div class="crud-data">
        <h3>Pizza kategóriák</h3>
        <table>
            <thead>
                <tr>
                    <th>Kategória</th>
                    <th>Ár (HUF)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($categories) === 0) { ?>
                    <tr><td colspan="2">Nincsenek mentett kategóriák.</td></tr>
                <?php } else { ?>
                    <?php foreach ($categories as $category) { ?>
                        <tr>
                            <td><?= htmlspecialchars($category['nev']) ?></td>
                            <td><?= htmlspecialchars($category['ar']) ?> Ft</td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>

        <h3>Pizzák a kategóriaár alapján</h3>
        <table>
            <thead>
                <tr>
                    <th>Pizza neve</th>
                    <th>Kategória</th>
                    <th>Vegetáriánus</th>
                    <th>Számított ár</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($items) === 0) { ?>
                    <tr><td colspan="6">Nincsenek mentett pizzák.</td></tr>
                <?php } else { ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nev']) ?></td>
                            <td><?= htmlspecialchars($item['kategoria']) ?></td>
                            <td><?= isset($item['vegetarianus']) && $item['vegetarianus'] ? 'Igen' : 'Nem' ?></td>
                            <td><?= isset($item['category_price']) && $item['category_price'] !== null ? htmlspecialchars($item['category_price']).' Ft' : 'N/A' ?></td>
                            <td class="crud-actions">
                                <a class="button button-edit" href="crud?action=edit&id=<?= htmlspecialchars($item['id']) ?>">Szerkeszt</a>
                                <a class="button button-delete" href="crud?action=delete&id=<?= htmlspecialchars($item['id']) ?>" onclick="return confirm('Tényleg törli a pizzát?');">Töröl</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
