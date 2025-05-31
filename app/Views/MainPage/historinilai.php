<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h2>Histori Nilai Ujian</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Ujian</th>
        <th>Nilai</th>
        <th>Tanggal Ujian</th>
    </tr>
    <?php if (!empty($nilai)): ?>
        <?php $no = 1;
        foreach ($nilai as $n): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($n['nama_ujian']); ?></td>
                <td><?= esc($n['nilai']); ?></td>
                <td><?= esc($n['tanggal_ujian']); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Belum ada data nilai.</td>
        </tr>
    <?php endif; ?>
</table>

<?= $this->endSection(); ?>