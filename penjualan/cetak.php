<?php

require 'ceklogin.php';
$h1 = mysqli_query($c, "select * from produk");
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
        <h1 class="text-left font-weight-light my-4">Laporan Stok Barang</h1>
        </div>
    </div>
</div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Barang
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok Barang</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $get = mysqli_query($c, "select * from produk");
                    $i = 1;

                    while ($p = mysqli_fetch_array($get)) {
                        $kode = $p['kode'];
                        $namaproduk = $p['namaproduk'];
                        $deskripsi = $p['deskripsi'];
                        $harga = $p['harga'];
                        $stok = $p['stok'];
                        $idproduk = $p['idproduk'];
                        $supplier = $p['supplier'];

                    ?>

                        <?php
                        $auto = mysqli_query($c, "select max(kode) as max_kode from produk");
                        $data = mysqli_fetch_array($auto);
                        $code = $data['max_kode'];
                        $urutan = (int)substr($code, 1, 3);
                        $urutan++;
                        $huruf = "A";
                        $kd_produk = $huruf . sprintf("%03s", $urutan);

                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $kode; ?></td>
                            <td><?= $namaproduk; ?></td>
                            <td><?= $deskripsi; ?></td>
                            <td>Rp <?= number_format($harga); ?></td>
                            <td><?= $stok; ?></td>
                            <td><?= $supplier; ?></td>
                        </tr>

                    <?php
                    };
                    ?>
                </tbody>
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