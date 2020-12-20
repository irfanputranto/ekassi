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

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;margin-bottom: 0px;"><?= $title; ?></h2>
    <p style="text-align: center;margin-top: -2px;font-size: 14px;margin-bottom: 0px;"><?= $tanggal; ?></p>
    <hr size="20px" />

    <table class="tablelaporan" width="100%">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Kode Bukti</th>
                <th class="text-center">Kode Akun</th>
                <th class="text-center">Nama Akun</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($laporandata as $key => $data) :
                $total += $data['jumlahkm'];
            ?>
                <tr>
                    <td style="text-align: center;"><?= ($key + 1) ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($data['tanggal_km'])); ?></td>
                    <td><?= $data['kdbuktikm']; ?></td>
                    <td><?= $data['kode_akun']; ?></td>
                    <td><?= $data['nama_akun']; ?></td>
                    <td><?= $data['ket_km']; ?></td>
                    <td style="text-align: right;"><?= number_format($data['jumlahkm'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center" colspan="6">Total</th>
                <th class="text-right"><?= number_format($total, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>