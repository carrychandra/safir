<?php
$config = json_decode(file_get_contents(__DIR__ . '/linktree.json'), true);
if (!$config) die("Gagal membaca konfigurasi.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($config['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="<?= htmlspecialchars($config['favicon']) ?>" type="image/webp">
    <link rel="icon" href="<?= htmlspecialchars($config['favicon']) ?>" type="image/webp">
    <link href="<?= htmlspecialchars($config['font_url']) ?>" rel="stylesheet">
    <style>
        /* Simple Modal Styles */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 1000;
        }
        .modal-content {
            background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%;
            overflow: auto;
        }
        .modal-close {
            float: right; cursor: pointer; font-size: 20px; color: red;
        }
        iframe {
            width: 100%; height: 300px; border: 0;
        }
    </style>
</head>
<body>

<!-- Background Animation -->
<section class="animated-background">
    <div id="stars1"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
</section>

<div class="min-h-full flex-h-center" id="background_div">
    <canvas id="bg-canvas" class="background-overlay"></canvas>
    <div class="mt-48 page-full-wrap relative">
        <img class="display-image m-auto"
             src="<?= htmlspecialchars($config['display_image']) ?>"
             alt="[Your photo alt]">
        <h2 class="page-title page-text-color page-text-font mt-16 text-center">
            <?= htmlspecialchars($config['username']) ?>
        </h2>

        <div class="mt-24">
            <?php foreach ($config['links'] as $link): ?>
                <div class="page-item-wrap relative">
                    <div class="page-item flex-both-center absolute"></div>

                    <?php if (!empty($link['is_modal'])): ?>
                        <!-- Modal Trigger -->
                        <a href="javascript:void(0);" onclick="openModal(`<?= htmlspecialchars($link['title']) ?>`, `<?= htmlspecialchars($link['map_embed']) ?>`, `<?= htmlspecialchars($link['url']) ?>`)"
                           class="page-item-each py-10 flex-both-center">
                            <img class="link-each-image" src="<?= htmlspecialchars($link['icon']) ?>">
                            <span class="item-title text-center"><?= htmlspecialchars($link['title']) ?></span>
                        </a>
                    <?php else: ?>
                        <a target="_blank"
                           href="<?= htmlspecialchars($link['url']) ?>"
                           class="page-item-each py-10 flex-both-center">
                            <img class="link-each-image" src="<?= htmlspecialchars($link['icon']) ?>">
                            <span class="item-title text-center"><?= htmlspecialchars($link['title']) ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div class="modal-overlay" id="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h3 id="modal-title"></h3>
        <iframe id="modal-map" loading="lazy" allowfullscreen></iframe>
        <p style="text-align:center; margin-top:10px;">
            <a href="#" target="_blank" id="modal-link">Lihat di Google Maps</a>
        </p>
    </div>
</div>

<script>
    function openModal(title, embedUrl, link) {
        document.getElementById("modal").style.display = "flex";
        document.getElementById("modal-title").innerText = title;
        document.getElementById("modal-map").src = embedUrl;
        document.getElementById("modal-link").href = link;
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
        document.getElementById("modal-map").src = ""; // stop map loading
    }

    window.onclick = function(e) {
        const modal = document.getElementById("modal");
        if (e.target === modal) closeModal();
    }
</script>

</body>
</html>
