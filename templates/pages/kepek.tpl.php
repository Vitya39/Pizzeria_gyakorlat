<section>
    <h2>Képgaléria</h2>
    <?php if (isset($uploadMessage)) { ?><p class="notice"><?= htmlspecialchars($uploadMessage) ?></p><?php } ?>
    <?php if (isset($_SESSION['login'])) { ?>
        <form action="kepek" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Kép feltöltése</legend>
                <label>
                    <span>Válassz képet</span>
                    <input type="file" name="kep" accept="image/*" required>
                </label>
                <input type="submit" name="feltolt" value="Feltöltés">
            </fieldset>
        </form>
    <?php } else { ?>
        <p class="hint">A kép feltöltéséhez jelentkezzen be.</p>
    <?php } ?>

    <div class="gallery">
        <?php if (count($images) === 0) { ?>
            <p>Nincs még feltöltött kép.</p>
        <?php } else { ?>
            <?php $imageIndex = 0; foreach ($images as $image) { ?>
                <figure>
                    <div class="gallery-image">
                        <img src="./images/uploads/<?= htmlspecialchars($image['fajlnev']) ?>" alt="Feltöltött kép" class="gallery-thumb" data-index="<?= $imageIndex ?>" data-caption="<?= htmlspecialchars($image['feltolto'] ? 'Feltöltő: '.$image['feltolto'] : 'Feltöltő: vendég') ?>">
                    </div>
                    <figcaption><?= htmlspecialchars($image['feltolto'] ? 'Feltöltő: '.$image['feltolto'] : 'Feltöltő: vendég') ?></figcaption>
                    <?php if (isset($_SESSION['login']) && $image['feltolto'] === $_SESSION['login']) { ?>
                        <form action="kepek" method="post" onsubmit="return confirm('Biztosan törölni szeretné ezt a képet?');">
                            <input type="hidden" name="image_id" value="<?= htmlspecialchars($image['id']) ?>">
                            <button type="submit" name="delete_image" value="1">Törlés</button>
                        </form>
                    <?php } ?>
                </figure>
            <?php $imageIndex++; } ?>
        <?php } ?>
    </div>

    <div class="lightbox-overlay" id="imageLightbox" aria-hidden="true">
        <button type="button" class="lightbox-close" aria-label="Bezárás">×</button>
        <button type="button" class="lightbox-nav prev" aria-label="Előző">‹</button>
        <button type="button" class="lightbox-nav next" aria-label="Következő">›</button>
        <div class="lightbox-content">
            <img id="lightboxImage" src="" alt="">
            <p id="lightboxCaption"></p>
        </div>
    </div>

    <script>
        (function() {
            var thumbs = document.querySelectorAll('.gallery-thumb');
            var overlay = document.getElementById('imageLightbox');
            var lightboxImage = document.getElementById('lightboxImage');
            var caption = document.getElementById('lightboxCaption');
            var prevBtn = overlay.querySelector('.lightbox-nav.prev');
            var nextBtn = overlay.querySelector('.lightbox-nav.next');
            var closeBtn = overlay.querySelector('.lightbox-close');
            var currentIndex = 0;
            var images = Array.prototype.map.call(thumbs, function(img) {
                return {
                    src: img.getAttribute('src'),
                    caption: img.getAttribute('data-caption') || ''
                };
            });

            function showLightbox(index) {
                if (index < 0) {
                    index = images.length - 1;
                } else if (index >= images.length) {
                    index = 0;
                }
                currentIndex = index;
                lightboxImage.src = images[index].src;
                lightboxImage.alt = images[index].caption || 'Kép';
                caption.textContent = images[index].caption;
                overlay.classList.add('active');
                overlay.setAttribute('aria-hidden', 'false');
            }

            function closeLightbox() {
                overlay.classList.remove('active');
                overlay.setAttribute('aria-hidden', 'true');
            }

            thumbs.forEach(function(img) {
                img.addEventListener('click', function() {
                    showLightbox(parseInt(this.getAttribute('data-index'), 10));
                });
            });

            prevBtn.addEventListener('click', function() {
                showLightbox(currentIndex - 1);
            });

            nextBtn.addEventListener('click', function() {
                showLightbox(currentIndex + 1);
            });

            closeBtn.addEventListener('click', closeLightbox);
            overlay.addEventListener('click', function(event) {
                if (event.target === overlay) {
                    closeLightbox();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (!overlay.classList.contains('active')) {
                    return;
                }
                if (event.key === 'Escape') {
                    closeLightbox();
                } else if (event.key === 'ArrowLeft') {
                    showLightbox(currentIndex - 1);
                } else if (event.key === 'ArrowRight') {
                    showLightbox(currentIndex + 1);
                }
            });
        })();
    </script>
</section>
