<?php

require 'ceklogin.php';
// $tgl_mulai = empty($_POST['tgl_mulai'])?"":$_POST['tgl_mulai'];
// $tgl_selesai = empty($_POST['tgl_selesai'])?"":$_POST['tgl_selesai'];
$h1 = mysqli_query($c, "select * from produk ta");
$h2 = mysqli_num_rows($h1); //jumlah produk 
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
        <h1 class="text-left font-weight-light my-4">Laporan Penjualan Barang</h1>
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
                        <th>Id Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['filter_tgl'])) {
                        $mulai = $_POST['tgl_mulai'];
                        $selesai = $_POST['tgl_selesai'];
                        $get = mysqli_query($c, "SELECT pesanan.*, detailpesanan.*, pelanggan.*, produk.* FROM (((pesanan 
                        INNER JOIN detailpesanan ON detailpesanan.idorder = pesanan.idorder)
                        INNER JOIN pelanggan ON pelanggan.idpelanggan = pesanan.idpelanggan)
                        INNER JOIN produk ON produk.idproduk = detailpesanan.idproduk) WHERE pesanan.tanggal BETWEEN '".$mulai."' and '".$selesai."'");
                    } else {
                        $get = mysqli_query($c, "SELECT pesanan.*, detailpesanan.*, pelanggan.*, produk.* FROM (((pesanan 
                        INNER JOIN detailpesanan ON detailpesanan.idorder = pesanan.idorder)
                        INNER JOIN pelanggan ON pelanggan.idpelanggan = pesanan.idpelanggan)
                        INNER JOIN produk ON produk.idproduk = detailpesanan.idproduk)");
                    }



                    $i = 1;

                    $pendapatan = 0;
                    while ($p = mysqli_fetch_array($get)) {
                        $idpelanggan = $p['idpelanggan'];
                        $namapelanggan = $p['namapelanggan'];
                        $kode = $p['kode'];
                        $namaproduk = $p['namaproduk'];
                        $deskripsi = $p['deskripsi'];
                        $qty = $p['qty'];
                        $harga = $p['harga'];
                        $subtotal = $p['subtotal'];
                        $tanggal = date('d F Y', strtotime($p['tanggal']));

                        $pendapatan = $pendapatan + $subtotal;
                    ?>

                        <tr>
                        <td><?= $i++; ?></td>
                            <td><?=$idpelanggan;?></td>
                            <td><?=$namapelanggan?></td>
                            <td><?= $kode; ?></td>
                            <td><?= $namaproduk; ?>: <?= $deskripsi; ?> </td>
                            <td><?= $qty; ?></td>
                            <td>Rp<?= number_format($harga); ?></td>
                            <td>Rp<?= number_format($subtotal); ?></td>
                             <td><?= $tanggal; ?></td>
                        </tr>

                    <?php
                    };
                    ?>
                </tbody>
            </table>

            Total Pendapatan : Rp<?= number_format($pendapatan, 0, ',','.') ?>
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