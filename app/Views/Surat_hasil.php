<!DOCTYPE html>
<html>
<head>
    <title>Surat Dinas</title>
</head>
<body>

<h2 style="text-align:center;">SURAT DINAS</h2>

<p>Nomor: <?= $nomor ?></p>
<p>Tanggal: <?= $tanggal ?></p>

<br>

<p>Kepada Yth:</p>
<p><?= $tujuan ?></p>

<br>

<p>Dengan hormat,</p>

<p><?= nl2br($isi) ?></p>

<br><br>

<p>Hormat kami,</p>
<p><b>Dinas Kominfo</b></p>

</body>
</html>