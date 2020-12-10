<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        .tablelaporan {
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            border-collapse: collapse;
        }

        .tablelaporan,
        th,
        td {
            border: 1px solid black;
            padding: 8px 10px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;margin-bottom: 0px;"><?= $title; ?></h2>
    <p style="text-align: center;margin-top: -2px;font-size: 14px;margin-bottom: 0px;"><?= $tanggal; ?></p>
    <hr size="20px" />

    <table class="tablelaporan">
        <thead>
            <tr style="text-align: center;">
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Nama Anggota</th>
                <th>Jabatan</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($laporandata as $key => $data) :
                $total += $data['uang_iuran'];
            ?>
                <tr>
                    <td style="text-align: center;"><?= ($key + 1) ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($data['tanggal_iuran'])); ?></td>
                    <td><?= $data['kode_akun']; ?></td>
                    <td><?= $data['nama_akun']; ?></td>
                    <td><?= $data['nama_anggota']; ?></td>
                    <td><?= $data['nama_jabatan']; ?></td>
                    <td><?= $data['keterangan']; ?></td>
                    <td style="text-align: right;"><?= number_format($data['uang_iuran'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">Total</th>
                <th style="text-align: right;"><?= number_format($total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>