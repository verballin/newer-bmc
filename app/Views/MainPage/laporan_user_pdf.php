<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Laporan Data User</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Status Ujian</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($users as $user): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['full_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= date('d-m-Y', strtotime($user['date_birth'])) ?></td>
                    <td><?= $user['gender'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td><?= $user['address'] ?></td>
                    <td><?= $user['boleh_ujian'] ? 'Diizinkan' : 'Belum Diizinkan' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>