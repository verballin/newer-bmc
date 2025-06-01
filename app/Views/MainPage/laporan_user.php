<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian User</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Kursus yang Dibeli User</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Kursus</th>
                <th>Status Pembayaran</th>
                <th>Tanggal</th>
                <p><a href="<?= base_url('laporan/user/pdf') ?>" target="_blank">🖨️ Cetak PDF</a></p>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row->username) ?></td>
                    <td><?= esc($row->kursus) ?></td>
                    <td><?= esc($row->status) ?></td>
                    <td><?= esc($row->created_at) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>