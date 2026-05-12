<?php ob_start(); ?>
/* ---- dashboard local styles ---- */

/* Welcome panel */
.welcome-panel {
    background: linear-gradient(135deg, rgba(15,118,110,0.95) 0%, rgba(13,148,136,0.88) 55%, rgba(170,115,38,0.78) 100%);
    border-radius: var(--radius-xl);
    padding: 1.25rem 1.5rem;
    margin-bottom: 0.85rem;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.welcome-panel::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -8%;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}

.welcome-panel > * { position: relative; z-index: 1; }

.welcome-name {
    font-size: 1.1rem;
    font-weight: 800;
    font-family: 'Fraunces', serif;
    color: #fff;
}

.welcome-meta {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.7);
    margin-top: 0.1rem;
}

.welcome-actions {
    display: flex;
    gap: 0.55rem;
    flex-shrink: 0;
}

/* Stat bar */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.65rem;
    margin-bottom: 0.85rem;
}

.dash-stat {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: 0.85rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.dash-stat-icon {
    font-size: 1.25rem;
    line-height: 1;
    flex-shrink: 0;
}

.dash-stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    font-family: 'Fraunces', serif;
    line-height: 1;
    color: var(--primary-deep);
}

.dash-stat-label {
    font-size: 0.7rem;
    color: var(--muted);
    font-weight: 600;
    margin-top: 0.1rem;
}

/* Chart card */
.chart-card {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    padding: 1.1rem 1.25rem;
}

.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    margin-bottom: 0.9rem;
}

.chart-card-title {
    font-size: 0.88rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}

.chart-card-sub {
    font-size: 0.74rem;
    color: var(--muted);
    margin: 0.05rem 0 0;
}

.chart-wrap {
    position: relative;
    height: 190px;
}

/* Menu kategori */
.menu-group {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 0.65rem;
}

.menu-group-label {
    font-size: 0.64rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0.6rem 1rem 0.45rem;
    border-bottom: 1px solid var(--line);
    background: rgba(248,246,242,0.7);
    display: block;
}

.menu-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.65rem 1rem;
    text-decoration: none;
    color: var(--text);
    border-bottom: 1px solid var(--line);
    transition: background 0.15s;
    font-size: 0.84rem;
    font-weight: 600;
}

.menu-row:last-child { border-bottom: none; }

.menu-row:hover {
    background: rgba(13,148,136,0.06);
    color: var(--primary-deep);
}

.menu-row.danger:hover {
    background: var(--danger-soft);
    color: var(--danger);
}

.menu-row-icon {
    font-size: 0.95rem;
    width: 28px;
    text-align: center;
    flex-shrink: 0;
}

.menu-row-arrow {
    margin-left: auto;
    color: var(--muted);
    font-size: 0.7rem;
    opacity: 0.5;
}

/* Admin welcome panel variant */
.welcome-panel-admin {
    background: linear-gradient(135deg, rgba(30,58,138,0.92) 0%, rgba(7,89,133,0.88) 50%, rgba(170,115,38,0.82) 100%);
}

.admin-badge {
    display: inline-block;
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    background: rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.92);
    border: 1px solid rgba(255,255,255,0.28);
    border-radius: 20px;
    padding: 0.13rem 0.55rem;
    margin-bottom: 0.3rem;
}

.dash-stats-heading {
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    margin: 0.55rem 0 0.3rem;
}

.dash-stat-admin {
    border-color: rgba(30,58,138,0.18);
    background: rgba(239,246,255,0.7);
}

.dash-stat-admin .dash-stat-value { color: #1e3a8a; }

@media (max-width: 640px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
    .dash-stat { padding: 0.7rem 0.85rem; gap: 0.6rem; }
    .dash-stat-value { font-size: 1.3rem; }
    .dash-stat-icon { font-size: 1.1rem; }
    .chart-wrap { height: 150px; }
    .welcome-panel {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem 1.1rem;
    }
    .welcome-actions { width: 100%; }
    .welcome-actions .btn { flex: 1; text-align: center; justify-content: center; }
    .menu-row { padding: 0.75rem 1rem; font-size: 0.88rem; }
    .chart-card { padding: 0.9rem 1rem; }
    .chart-card-title { font-size: 0.84rem; }
}
<?php
$pageStyles = ob_get_clean();
/** @var string $username */
/** @var string $nama */
/** @var string $role */
/** @var int $totalSurat */
/** @var int $suratBulanIni */
/** @var int|null $totalPegawai */
/** @var int|null $totalRekening */
/** @var int|null $totalUser */
/** @var string $chartLabels */
/** @var string $chartData */
?>
<?= view('_partials/head', ['title' => 'Dashboard - ARUNIKA', 'pageStyles' => $pageStyles]) ?>
<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-copy">
            <div class="hero-kicker">Workspace SPT & SPD</div>
            <h1>Dashboard</h1>
            <div class="meta">Panel kerja utama &ndash; buat surat, kelola referensi, pantau aktivitas.</div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <div class="grid-2" style="align-items:start;">

        <!-- ============ KOLOM KIRI ============ -->
        <div>
            <!-- Welcome banner -->
            <div class="welcome-panel <?= $role === 'admin' ? 'welcome-panel-admin' : '' ?>">
                <div>
                    <?php if ($role === 'admin'): ?>
                        <div class="admin-badge">&#9679; Administrator</div>
                    <?php endif; ?>
                    <div class="welcome-name">Halo, <?= esc($nama ?: $username) ?>! &#128075;</div>
                    <div class="welcome-meta">
                        <?php if ($role === 'admin'): ?>
                            Panel Admin &ndash; Kelola semua data &amp; pengguna sistem.
                        <?php else: ?>
                            <?= esc($unit_kerja ?? 'ARUNIKA') ?> &ndash; Selamat datang kembali.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="welcome-actions">
                    <a class="btn btn-light btn-sm" href="/surat">+ SPT &amp; SPD</a>
                    <?php if ($role === 'admin'): ?>
                        <a class="btn btn-secondary btn-sm" href="/users">&#128101; Pengguna</a>
                    <?php else: ?>
                        <a class="btn btn-secondary btn-sm" href="/surat/history">Riwayat</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stat cards -->
            <div class="dash-stats">
                <?php if ($role === 'admin'): ?>
                <div class="dash-stat" style="grid-column: 1 / -1; padding: 0.3rem 0; background:none; border:none; box-shadow:none;">
                    <div class="dash-stats-heading" style="margin:0;">&#128202; Aktivitas Surat</div>
                </div>
                <?php endif; ?>
                <div class="dash-stat">
                    <div class="dash-stat-icon">&#128196;</div>
                    <div>
                        <div class="dash-stat-value"><?= $totalSurat ?></div>
                        <div class="dash-stat-label"><?= $role === 'admin' ? 'Total Surat' : 'Surat Saya' ?></div>
                    </div>
                </div>
                <div class="dash-stat">
                    <div class="dash-stat-icon">&#128197;</div>
                    <div>
                        <div class="dash-stat-value"><?= $suratBulanIni ?></div>
                        <div class="dash-stat-label">Bulan Ini</div>
                    </div>
                </div>
                <?php if ($totalPegawai !== null): ?>
                <div class="dash-stat" style="grid-column: 1 / -1; padding: 0.3rem 0; background:none; border:none; box-shadow:none; margin-top:0.25rem;">
                    <div class="dash-stats-heading" style="margin:0;">&#127963; Ringkasan Sistem</div>
                </div>
                <div class="dash-stat dash-stat-admin">
                    <div class="dash-stat-icon">&#128101;</div>
                    <div>
                        <div class="dash-stat-value"><?= $totalPegawai ?></div>
                        <div class="dash-stat-label">Pegawai</div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($totalRekening !== null): ?>
                <div class="dash-stat dash-stat-admin">
                    <div class="dash-stat-icon">&#128179;</div>
                    <div>
                        <div class="dash-stat-value"><?= $totalRekening ?></div>
                        <div class="dash-stat-label">Rekening</div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($totalUser !== null): ?>
                <div class="dash-stat dash-stat-admin">
                    <div class="dash-stat-icon">&#128100;</div>
                    <div>
                        <div class="dash-stat-value"><?= $totalUser ?></div>
                        <div class="dash-stat-label">Pengguna</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Chart -->
            <div class="chart-card">
                <div class="chart-card-header">
                    <div>
                        <p class="chart-card-title">Surat Dibuat per Bulan</p>
                        <p class="chart-card-sub">12 bulan terakhir &ndash; <?= $role === 'admin' ? 'semua pengguna' : 'akun Anda' ?></p>
                    </div>
                    <span class="eyebrow" style="margin:0;">Tren</span>
                </div>
                <div class="chart-wrap">
                    <canvas id="suratChart"></canvas>
                </div>
            </div>
        </div>

        <!-- ============ KOLOM KANAN ============ -->
        <aside>

            <?php if ($role === 'admin'): ?>
            <!-- Administrasi (admin only) -->
            <div class="menu-group" style="border-top: 3px solid #1e3a8a;">
                <span class="menu-group-label" style="color:#1e3a8a;">Administrasi</span>
                <a class="menu-row" href="/users">
                    <span class="menu-row-icon">&#128101;</span> Manajemen User
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/users/active">
                    <span class="menu-row-icon">&#128994;</span> User Aktif
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/pegawai/manage">
                    <span class="menu-row-icon">&#128100;</span> Data Pegawai
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/rekening/manage">
                    <span class="menu-row-icon">&#128179;</span> Kode Rekening
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/template/manage">
                    <span class="menu-row-icon">&#128196;</span> Template Dokumen
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/pengaturan/perjadin">
                    <span class="menu-row-icon">&#9881;</span> Pengaturan Perjadin
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/notifikasi">
                    <span class="menu-row-icon">&#128276;</span> Notifikasi User
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
            </div>
            <?php endif; ?>

            <!-- Surat -->
            <div class="menu-group">
                <span class="menu-group-label">Surat</span>
                <a class="menu-row" href="/surat">
                    <span class="menu-row-icon">&#128221;</span> Buat SPT &amp; SPD
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row" href="/surat/history">
                    <span class="menu-row-icon">&#128203;</span> Riwayat Surat
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
            </div>

            <!-- Akun -->
            <div class="menu-group">
                <span class="menu-group-label">Akun</span>
                <a class="menu-row" href="/profil">
                    <span class="menu-row-icon">&#128100;</span> Profil Saya
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
                <a class="menu-row danger" href="/logout">
                    <span class="menu-row-icon">&#128682;</span> Keluar
                    <span class="menu-row-arrow">&rsaquo;</span>
                </a>
            </div>

        </aside>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    var labels = <?= $chartLabels ?>;
    var data   = <?= $chartData ?>;

    var ctx = document.getElementById('suratChart').getContext('2d');

    var gradient = ctx.createLinearGradient(0, 0, 0, 190);
    gradient.addColorStop(0, 'rgba(13,148,136,0.28)');
    gradient.addColorStop(1, 'rgba(13,148,136,0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Surat Dibuat',
                data: data,
                backgroundColor: gradient,
                borderColor: 'rgba(13,148,136,0.8)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(13,148,136,0.45)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a2332',
                    titleColor: 'rgba(255,255,255,0.65)',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(ctx) { return ' ' + ctx.parsed.y + ' surat'; }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 10, weight: '600' }, maxRotation: 45 },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(100,80,50,0.07)' },
                    ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1, precision: 0 },
                    border: { display: false }
                }
            }
        }
    });
})();
</script>

<?= view('_partials/footer') ?>
