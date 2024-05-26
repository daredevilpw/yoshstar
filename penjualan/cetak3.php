<?php

require 'ceklogin.php';

if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
    $ambilpelanggan = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan and p.idorder='$idp'");
    $np = mysqli_fetch_array($ambilpelanggan);
    $namapel = $np['namapelanggan'];
    $notelp = $np['notelp'];
    $alamat = $np['alamat'];
    $tanggalpesan = $np['tanggal'];
} else {
    header('location:index.php');
}

?>
<?php 
  $get = mysqli_query($c, "select * from detailpesanan p, produk pr where p.idproduk=pr.idproduk and idorder='$idp'");
  $i = 1;
  $grandtotal=0;

  
  
?>
<?php
    $get2 = mysqli_query($c, "select SUM(subtotal) AS grandtotal FROM detailpesanan WHERE idorder='$idp'");
    while ($p = mysqli_fetch_array($get2)) {
        $grandtotal = $p['grandtotal'];
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="styles2.css">
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                <img src="BBC.jpeg" style="float:left;width: 100px;" >
                    <h2>Bukti Pembayaran No : <?= $idp;?></h2>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Billed To:</strong><br>
                            <?=$namapel;?><br>
                            <?=$notelp;?><br>
                            <?=$alamat;?> <br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                        <strong>Order Date:</strong><br>
                            <?=$tanggalpesan;?><br><br>
                        </address>
                    </div>
                </div>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Item</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <?php
                                        while ($p = mysqli_fetch_array($get)) {
                                            $idpr = $p['idproduk'];
                                            $iddp = $p['iddetail'];
                                            $kode = $p['kode'];
                                            $qty = $p['qty'];
                                            $harga = $p['harga'];
                                            $namaproduk = $p['namaproduk'];
                                            $desc = $p['deskripsi'];
                                            $subtotal = $p['subtotal'];
                                          
                                    ?>
                                    <tr>
                                        <td><?= $namaproduk; ?> (<?= $desc; ?>)</td>
                                        <td class="text-center">Rp<?= number_format($harga); ?></td>
                                        <td class="text-center"><?= number_format($qty); ?></td>
                                        <td class="text-right">Rp<?= number_format($subtotal); ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>

                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Total</strong></td>
                                        <td class="thick-line text-right">Rp<?= number_format($grandtotal); ?></td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Pesanan Pelanggan
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>ID Pesanan Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan");
                    $i = 1;

                    while ($p = mysqli_fetch_array($get)) {
                        $idorder = $p['idorder'];
                        $tanggal = $p['tanggal'];
                        $namapelanggan = $p['namapelanggan'];
                        $alamat = $p['alamat'];

                        $hitungjumlah = mysqli_query($c, "select * from detailpesanan where idorder='$idorder'");
                        $jumlah = mysqli_num_rows($hitungjumlah);
                    ?>

                        <tr>
                            <td><?= $idorder; ?></td>
                            <td><?= $tanggal; ?></td>
                            <td><?= $namapelanggan; ?> - <?= $alamat; ?></td>
                            <td><?= $jumlah; ?></td>
                        </tr>

                    <?php
                    };
                    ?>
                </tbody>-->
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



