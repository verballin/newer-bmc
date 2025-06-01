<!DOCTYPE html>
<html>

<head>
    <title>Laporan Nilai Ujian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Laporan Hasil Nilai Ujian</h3>
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
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->full_name ?></td>
                    <td><?= $row->nama_ujian ?></td>
                    <td><?= $row->nilai ?></td>
                    <td><?= $row->status ?></td>
                    <td><?= $row->tanggal ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>