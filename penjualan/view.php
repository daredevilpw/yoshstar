<?php
require 'ceklogin.php';

if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
    $ambilpelanggan = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan and p.idorder='$idp'");
    $np = mysqli_fetch_array($ambilpelanggan);
    $namapel = $np['namapelanggan'];
} else {
    header('location:index.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Detail Pesanan</title>
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
                    <h1 class="mt-4">Data Pesanan: <?= $idp; ?></h1>
                    <h4 class="mt-4">Nama Pelanggan: <?= $namapel; ?></h4>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang</li>
                    </ol>
                    <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Barang
                    </button>
                    <a href="cetak3.php?idp=<?= $_GET['idp'] ?>" class="btn btn-info mb-4" target ="blank">Print</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pesanan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Sub-total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get = mysqli_query($c, "select * from detailpesanan p, produk pr where p.idproduk=pr.idproduk and idorder='$idp'");
                                    $i = 1;
                                    $grandtotal=0;

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

                                        <?php
                                        $get2 = mysqli_query($c, "select SUM(subtotal) AS grandtotal FROM detailpesanan WHERE idorder='$idp'");
                                        while ($p = mysqli_fetch_array($get2)) {
                                            $grandtotal = $p['grandtotal'];
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $kode; ?></td>
                                                <td><?= $namaproduk; ?> (<?= $desc; ?>)</td>
                                                <td>Rp<?= number_format($harga); ?></td>
                                                <td><?= number_format($qty); ?></td>
                                                <td>Rp<?= number_format($subtotal); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idpr; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idpr; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="edit<?= $idpr; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Ubah Data Detail Pesanan </h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <form method="post">
                                                            <!-- Modal body -->

                                                            <div class="modal-body">
                                                                <input type="text" name="kode" class="form-control" value="<?= $kode; ?>" disabled>
                                                                <input type="text" name="namaproduk" class="form-control" value="<?= $namaproduk; ?>: <?= $desc; ?>" disabled>
                                                                <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" value="<?= $qty; ?>" min="1" required>
                                                                <input type="hidden" name="iddp" value="<?= $iddp; ?>">
                                                                <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                                <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success" name="editdetail">Submit</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="delete<?= $idpr; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Apakah anda ingin menghapus barang ini ?</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <form method="post">
                                                            <!-- Modal body -->

                                                            <div class="modal-body">
                                                                Apakah anda ingin menghapus barang ini ?
                                                                <input type="hidden" name="idp" value="<?= $iddp; ?>">
                                                                <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                                                                <input type="hidden" name="idorder" value="<?= $idp; ?>">
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Ya</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    };
                                    ?>

                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th>Total : </th>
                                        <td>Rp<?= number_format($grandtotal); ?></td>
                                    </tr>
                                </tfooter>
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
                            $getproduk = mysqli_query($c, "select * from produk where idproduk not in (select idproduk from detailpesanan where idorder='$idp')");

                            while ($pl = mysqli_fetch_array($getproduk)) {
                                $namaproduk = $pl['namaproduk'];
                                $deskripsi = $pl['deskripsi'];
                                $stok = $pl['stok'];
                                $idproduk = $pl['idproduk'];
                            ?>
                                <option value="<?= $idproduk; ?>"><?= $namaproduk; ?> - <?= $deskripsi; ?> (Stok : <?= $stok; ?>)</option>
                            <?php
                            }
                            ?>
                        </select>

                        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>