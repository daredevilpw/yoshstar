<?php

require 'ceklogin.php';
// $tgl_mulai = empty($_POST['tgl_mulai'])?"":$_POST['tgl_mulai'];
// $tgl_selesai = empty($_POST['tgl_selesai'])?"":$_POST['tgl_selesai'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles1.css">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Print
    </title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <img src="BBC.jpeg" style="float:left;width: 200px;" >
        <div class="col" >
        <h1 class="text-left font-weight-light my-4">Laporan Pembelian Barang</h1>
        </div>
    </div>
</div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Barang
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['filter_tgl'])) {
                        $mulai = $_POST['tgl_mulai'];
                        $selesai = $_POST['tgl_selesai'];
                        $get = mysqli_query($c, "SELECT masuk.tanggal, produk.*, masuk.qty, masuk.idmasuk  FROM produk INNER JOIN masuk ON masuk.idproduk = produk.idproduk WHERE masuk.tanggal BETWEEN '".$mulai."' and '".$selesai."'");
                    } else {
                        $get = mysqli_query($c, "select * from masuk m, produk p where m.idproduk=p.idproduk ");
                    }



                    $i = 1;

                    $pendapatan = 0;
                    while ($p = mysqli_fetch_array($get)) {
                        $kode = $p['kode'];
                        $namaproduk = $p['namaproduk'];
                        $deskripsi = $p['deskripsi'];
                        $qty = $p['qty'];
                        $tanggal = date('d F Y', strtotime($p['tanggal']));
                        $harga = $p['harga'];
                        $idmasuk = $p['idmasuk'];
                        $idproduk = $p['idproduk'];

                        $totalHarga = $qty * $harga;
                        $pendapatan = $pendapatan + $totalHarga;
                    ?>

                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $kode; ?></td>
                            <td><?= $namaproduk; ?>: <?= $deskripsi; ?> </td>
                            <td><?= $qty; ?></td>
                            <td><?= number_format($totalHarga, 0, ',','.'); ?></td>
                            <td><?= $tanggal; ?></td>
                        </tr>

                    <?php
                    };
                    ?>
                </tbody>
            </table>

            Total Pembelian : Rp<?= number_format($pendapatan, 0, ',','.') ?>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="js/scripts.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
                <script src="assets/demo/chart-area-demo.js"></script>
                <script src="assets/demo/chart-bar-demo.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
                <script src="js/datatables-simple-demo.js"></script>
                <script>
                    window.print();
                </script>
</body>

</html>