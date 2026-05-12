<?php
$currentPath = trim(parse_url(current_url(), PHP_URL_PATH) ?? '', '/');
$role = service('session')->get('role') ?? 'user';
$isAdmin = ($role === 'admin');

$navItems = [
    ['href' => '/dashboard', 'label' => 'Dashboard'],
    ['href' => '#', 'label' => 'Buat Surat', 'children' => [
        ['href' => '/surat',                  'label' => 'SPT & SPD'],
        ['href' => '/surat/permohonantte',     'label' => 'Permohonan TTE'],
        ['href' => '/surat/notadinastte',      'label' => 'Nota Dinas TTE'],
        ['href' => '/surat/rincianperjadin',   'label' => 'Rincian Perjadin'],
    ]],
    ['href' => '/surat/history', 'label' => 'Riwayat'],
];

if ($isAdmin) {
    $navItems[] = ['href' => '/template/manage', 'label' => 'Template'];
    $navItems[] = ['href' => '#', 'label' => 'Kelola', 'children' => [
        ['href' => '/pegawai/manage',       'label' => 'Data Pegawai'],
        ['href' => '/rekening/manage',      'label' => 'Kode Rekening'],
        ['href' => '/users',                'label' => 'Manajemen User'],
        ['href' => '/users/active',         'label' => 'User Aktif'],
        ['href' => '/pengaturan/perjadin',  'label' => 'Pengaturan Perjadin'],
        ['href' => '/pengaturan/dasar',     'label' => 'Dasar Surat'],
        ['href' => '/pengaturan/paraf',     'label' => 'Paraf Hirarki'],
        ['href' => '/notifikasi',           'label' => 'Notifikasi User'],
    ]];
}

$navItems[] = ['href' => '/profil', 'label' => 'Profil'];

$drawerItems = [
    ['href' => '/dashboard', 'label' => 'Dashboard', 'note' => 'Ringkasan aplikasi'],
    ['type' => 'group', 'label' => 'Buat Surat', 'children' => [
        ['href' => '/surat',                'label' => 'SPT & SPD',        'note' => 'Generate SPT & SPD'],
        ['href' => '/surat/permohonantte',  'label' => 'Permohonan TTE',  'note' => 'Sertifikat Elektronik BSrE'],
        ['href' => '/surat/notadinastte',   'label' => 'Nota Dinas TTE',  'note' => 'Surat pendukung TTE'],
        ['href' => '/surat/rincianperjadin','label' => 'Rincian Perjadin','note' => 'Rincian biaya perjalanan dinas'],
    ]],
    ['href' => '/surat/history', 'label' => 'Riwayat Surat', 'note' => 'Log generate terbaru'],
];

if ($isAdmin) {
    $drawerItems[] = ['href' => '/template/manage', 'label' => 'Template', 'note' => 'Kelola file dokumen'];
    $drawerItems[] = ['type' => 'group', 'label' => 'Kelola Data', 'children' => [
        ['href' => '/pegawai/manage',      'label' => 'Data Pegawai',        'note' => 'Profil ASN dan staf'],
        ['href' => '/rekening/manage',     'label' => 'Kode Rekening',       'note' => 'Referensi pembiayaan'],
        ['href' => '/users',               'label' => 'Manajemen User',      'note' => 'Kelola akun pengguna'],
        ['href' => '/users/active',        'label' => 'User Aktif',          'note' => 'Sesi login saat ini'],
        ['href' => '/pengaturan/perjadin', 'label' => 'Pengaturan Perjadin', 'note' => 'Tarif harian, BBM, penginapan'],
        ['href' => '/pengaturan/dasar',    'label' => 'Dasar Surat',         'note' => 'Dasar hukum pada SPT'],
        ['href' => '/pengaturan/paraf',    'label' => 'Paraf Hirarki',       'note' => 'Label baris tanda tangan SPT'],
        ['href' => '/notifikasi',          'label' => 'Notifikasi User',     'note' => 'Kelola popup pemberitahuan'],
    ]];
}

$drawerItems[] = ['href' => '/profil', 'label' => 'Profil', 'note' => 'Ubah password & nama bidang'];
?>

<!-- ===== INLINE TOP NAVBAR (rendered inside hero) ===== -->
<nav class="topnav" aria-label="Navigasi utama">
    <div class="topnav-brand">
        <span class="topnav-brand-icon" aria-hidden="true">S</span>
        ARUNIKA
    </div>

    <div class="topnav-links">
        <?php foreach ($navItems as $item): ?>
            <?php if (isset($item['children'])): ?>
                <?php
                    $childPaths = array_map(fn($c) => trim($c['href'], '/'), $item['children']);
                    $isActive = in_array($currentPath, $childPaths);
                ?>
                <div class="topnav-dropdown">
                    <button type="button" class="topnav-link topnav-dropdown-toggle<?= $isActive ? ' active' : '' ?>">
                        <?= esc($item['label']) ?> ▾
                    </button>
                    <div class="topnav-dropdown-menu">
                        <?php foreach ($item['children'] as $child): ?>
                            <?php /** @var array{href:string,label:string,note?:string} $child */ ?>
                            <?php $cPath = trim($child['href'], '/'); ?>
                            <a href="<?= $child['href'] ?>" class="topnav-dropdown-item<?= $currentPath === $cPath ? ' active' : '' ?>"><?= esc($child['label']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <?php $itemPath = trim($item['href'], '/'); ?>
                <?php $isActive = $currentPath === $itemPath || str_starts_with($currentPath, $itemPath . '/'); ?>
                <a href="<?= $item['href'] ?>" class="topnav-link<?= $isActive ? ' active' : '' ?>"><?= esc($item['label']) ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
        <a href="/logout" class="topnav-link logout-link">Logout</a>
    </div>

    <button class="hamburger" type="button" onclick="openDrawer()" aria-label="Buka menu">
        <span class="hamburger-bar"></span>
    </button>
</nav>

<!-- ===== MOBILE DRAWER ===== -->
<div class="drawer-backdrop" id="drawerBackdrop" onclick="closeDrawer()"></div>
<div class="drawer" id="drawer" aria-hidden="true">
    <div class="drawer-header">
        <div class="drawer-brand">
            <strong>ARUNIKA</strong>
            <small>Sistem Informasi Surat Dinas</small>
        </div>
        <button class="drawer-close" type="button" onclick="closeDrawer()" aria-label="Tutup menu">✕</button>
    </div>

    <nav class="drawer-nav">
        <?php foreach ($drawerItems as $item): ?>
            <?php /** @var array{href?:string,label:string,note?:string,type?:string,children?:array<int,array{href:string,label:string,note:string}>} $item */ ?>
            <?php if (isset($item['type']) && $item['type'] === 'group'): ?>
                <div class="drawer-group-label"><?= esc($item['label']) ?></div>
                <?php foreach ($item['children'] as $child): ?>
                    <?php /** @var array{href:string,label:string,note:string} $child */ ?>
                    <?php $itemPath = trim($child['href'], '/'); ?>
                    <?php $isActive = $currentPath === $itemPath || str_starts_with($currentPath, $itemPath . '/'); ?>
                    <a href="<?= $child['href'] ?>" class="drawer-link drawer-link-nested<?= $isActive ? ' active' : '' ?>">
                        <span><?= esc($child['label']) ?></span>
                        <small><?= esc($child['note']) ?></small>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $itemPath = trim($item['href'], '/'); ?>
                <?php $isActive = $currentPath === $itemPath || str_starts_with($currentPath, $itemPath . '/'); ?>
                <a href="<?= $item['href'] ?>" class="drawer-link<?= $isActive ? ' active' : '' ?>">
                    <span><?= esc($item['label']) ?></span>
                    <small><?= esc($item['note']) ?></small>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
        <a href="/logout" class="drawer-link logout">
            <span>Logout</span>
            <small>Akhiri sesi</small>
        </a>
    </nav>

    <div class="drawer-footer">ARUNIKA &copy; <?= date('Y') ?></div>
</div>

<script>
function openDrawer() {
    document.getElementById('drawer').classList.add('open');
    document.getElementById('drawerBackdrop').classList.add('open');
    document.getElementById('drawer').setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    document.getElementById('drawer').classList.remove('open');
    document.getElementById('drawerBackdrop').classList.remove('open');
    document.getElementById('drawer').setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}
</script>