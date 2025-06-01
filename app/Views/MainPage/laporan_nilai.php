<!DOCTYPE html>
<html>

<head>
    <title>Laporan Nilai Ujian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #666;
            padding: 8px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Hasil Nilai Ujian</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Nama Ujian</th>
                <th>Nilai</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
            <p><a href="<?= base_url('laporan/pdf') ?>" target="_blank">🖨️ Cetak PDF</a></p>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row->full_name) ?></td>
                    <td><?= esc($row->nama_ujian) ?></td>
                    <td><?= esc($row->nilai) ?></td>
                    <td><?= esc($row->status) ?></td>
                    <td><?= esc($row->tanggal) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>