<section>
    <h2>Üzenetek</h2>
    <?php if (!isset($_SESSION['login'])) { ?>
        <p class="notice">Csak bejelentkezett felhasználók látják az üzeneteket.</p>
    <?php } else { ?>
        <?php if (count($messages) === 0) { ?>
            <p>Még nincs elküldött üzenet.</p>
        <?php } else { ?>
            <table>
                <caption>Elküldött üzenetek</caption>
                <thead>
                    <tr>
                        <th>Küldő</th>
                        <th>Érkezett</th>
                        <th>Tárgy</th>
                        <th>Üzenet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message) { ?>
                        <tr>
                            <td><?= htmlspecialchars($message['felhasznalo'] ? $message['felhasznalo'] : 'Vendég') ?></td>
                            <td><?= htmlspecialchars($message['bekuldes']) ?></td>
                            <td><?= htmlspecialchars($message['targy']) ?></td>
                            <td><?= nl2br(htmlspecialchars($message['uzenet'])) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    <?php } ?>
</section>
