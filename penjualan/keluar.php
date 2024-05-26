<?php

require 'ceklogin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a href ="index.php" class="navbar-brand ps-2"><img src="BBC.jpeg" style="width: 75px;border-radius: 10px;" ></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stock.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck-pickup"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck-pickup"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                            Data Pelanggan
                        </a>
                        <a class="nav-link" href="supplier.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Supplier
                            </a>
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <?php
                    $get1 = mysqli_query($c, "select * from user");
                    $user = mysqli_fetch_array($get1);
                    $email = $user['username'];
                    ?>
                    <div class="small">Logged in as:</div>
                    <?= $email; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Barang Keluar</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang</li>
                    </ol>
                    
                    <form action="cetak4.php" method="post" target="_blank" class="d-inline">
                    <button type="submit" onclick="return confirm('Printing...')" name="filter_tgl" class="btn btn-info mb-4">Print</button>
                    <br>
                    <div class="row"> 
                        <div class="col xl-0">
                            <form method="post" class="form-inline mb-1">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Mulai</label>
                                            <input type="date" required name="tgl_mulai" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Tanggal Selesai</label>
                                            <input type="date" required name="tgl_selesai" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </form>
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
                                        INNER JOIN produk ON produk.idproduk = detailpesanan.idproduk) where pesanan.tanggal BETWEEN ".$mulai."' and '".$selesai."'");
                                    } else {
                                        $get = mysqli_query($c, "SELECT pesanan.*, detailpesanan.*, pelanggan.*, produk.* FROM (((pesanan 
                                        INNER JOIN detailpesanan ON detailpesanan.idorder = pesanan.idorder)
                                        INNER JOIN pelanggan ON pelanggan.idpelanggan = pesanan.idpelanggan)
                                        INNER JOIN produk ON produk.idproduk = detailpesanan.idproduk)");
                                    }



                                    $i = 1;

                                    while ($p = mysqli_fetch_array($get)) {
                                        $idpelanggan = $p['idpelanggan'];
                                        $namapelanggan = $p['namapelanggan'];
                                        $kode = $p['kode'];
                                        $namaproduk = $p['namaproduk'];
                                        $deskripsi = $p['deskripsi'];
                                        $qty = $p['qty'];
                                        $harga = $p['harga'];
                                        $subtotal = $p['subtotal'];
                                        $tanggal = $p['tanggal'];
                                        
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

                                        <div class="modal fade" id="edit<?= $idmasuk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data Barang Masuk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <!-- Modal body -->

                                                        <div class="modal-body">
                                                            <input type="text" name="kode" class="form-control" value="<?= $kode; ?>" disabled>
                                                            <input type="text" name="namaproduk" class="form-control" value="<?= $namaproduk; ?>: <?= $deskripsi; ?>" disabled>
                                                            <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" value="<?= $qty; ?>" min="1" required>
                                                            <input type="hidden" name="idm" value="<?= $idmasuk; ?>">
                                                            <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editbarangmasuk">Submit</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="modal fade" id="delete<?= $idmasuk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Data Barang Masuk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <!-- Modal body -->

                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus data ini?
                                                            <input type="hidden" name="idm" value="<?= $idmasuk; ?>">
                                                            <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="deletebarangmasuk">Submit</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    };
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; BBC Website</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Baru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post">
                    <!-- Modal body -->

                    <div class="modal-body">
                        Pilih Barang
                        <select name="idproduk" class="form-control">
                            <?php
                            $getproduk = mysqli_query($c, "select * from produk");

                            while ($pl = mysqli_fetch_array($getproduk)) {
                                $kode = $pl['kode'];
                                $namaproduk = $pl['namaproduk'];
                                $deskripsi = $pl['deskripsi'];
                                $stok = $pl['stok'];
                                $idproduk = $pl['idproduk'];
                                $namasupplier = $pl['supplier'];
                            ?>
                                <option value="<?= $idproduk; ?>"><?= $kode; ?> - <?= $namaproduk; ?> - <?= $deskripsi; ?> (Stok : <?= $stok; ?>) - <?= $namasupplier;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>


</html>