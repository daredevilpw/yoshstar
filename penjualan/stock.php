<?php

require 'ceklogin.php';
$h1 = mysqli_query($c, "select * from produk");
$h2 = mysqli_num_rows($h1); //jumlah produk 
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
                    <h1 class="mt-4">Stok Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Barang : <?= $h2; ?></div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Barang Baru
                    </button>
                    <a href="cetak.php" class="btn btn-info mb-4" target ="blank">Print</a> 
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
                                        <th>Action</th>
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
                                            <td>Rp<?= number_format($harga); ?></td>
                                            <td><?= $stok; ?></td>
                                            <td><?= $supplier; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idproduk; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idproduk; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>


                                        <div class="modal fade" id="edit<?= $idproduk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah <?= $namaproduk; ?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <!-- Modal body -->

                                                        <div class="modal-body">
                                                            <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" value="<?= $namaproduk; ?>" required>
                                                            <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi Produk" value="<?= $deskripsi; ?>" required>
                                                            <input type="num" name="harga" class="form-control mt-2" placeholder="Harga Produk" value="<?= $harga; ?>" required>
                                                            <select name="supplier" class="form-control">
                                                                <?php
                                                                $getproduk = mysqli_query($c, "select * from supplier");

                                                                while ($pl = mysqli_fetch_array($getproduk)) {
                                                                    $namasupplier = $pl['namasupplier'];
                                                                    $alamat = $pl['alamat'];
                                                                    $notelp = $pl['notelp'];
                                                                ?>
                                                                    <option value="<?= $namasupplier; ?>"> <?= $namasupplier; ?> - <?= $alamat; ?> - <?= $notelp; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editbarang">Submit</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="modal fade" id="delete<?= $idproduk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus <?= $namaproduk; ?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <!-- Modal body -->

                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus barang ini?
                                                            <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="deletebarang">Submit</button>
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
                        <input type="text" name="kode" class="form-control" value="<?= $kd_produk; ?>" placeholder="Kode Produk">
                        <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" required>
                        <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi Produk" required>
                        <input type="num" name="stok" class="form-control mt-2" placeholder="Stok Awal" required>
                        <input type="num" name="harga" class="form-control mt-2" placeholder="Harga Produk" required>
                        <select name="supplier" class="form-control">
                            <?php
                            $getproduk = mysqli_query($c, "select * from supplier");

                            while ($pl = mysqli_fetch_array($getproduk)) {
                                $namasupplier = $pl['namasupplier'];
                                $alamat = $pl['alamat'];
                                $notelp = $pl['notelp'];
                            ?>
                                <option value="<?= $namasupplier; ?>"> <?= $namasupplier; ?> - <?= $alamat; ?> - <?= $notelp; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahbarang">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>


</html>