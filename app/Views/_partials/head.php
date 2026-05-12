<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ARUNIKA') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/Kabupaten-Muara-Enim.png') ?>">

    <!-- Apply saved theme immediately to prevent FOUC -->
    <script>(function(){var t=localStorage.getItem('arunika_theme');if(t&&t!=='default')document.documentElement.setAttribute('data-theme',t);})();</script>

    <!-- Preconnect untuk mempercepat resource loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Fonts: non-blocking dengan display=swap -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" media="print" onload="this.media='all'">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/sitante.css') ?>">
    <?php if (!empty($pageStyles)): ?><style><?= $pageStyles ?></style><?php endif; ?>
</head>
<body<?= !empty($bodyClass) ? ' class="' . esc($bodyClass) . '"' : '' ?>>
