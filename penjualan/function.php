<?php

session_start();

$c = mysqli_connect('localhost','root','','penjualan');

//login
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query ($c, "SELECT * FROM user WHERE username='$username' and password='$password'" );

    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        $_SESSION['login'] = 'True';
        header('location:index.php');
    }else{
    echo'
    <script>
    alert("Username atau Password salah");
    window.location.href="login.php"
    </script>';

    }
}

//tambahbarang
if(isset($_POST['tambahbarang'])){
    $kode = $_POST['kode'];
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $supplier = $_POST['supplier'];

    $insert = mysqli_query($c,"insert into produk (kode,namaproduk,deskripsi,harga,stok,supplier) values ('$kode','$namaproduk','$deskripsi','$harga','$stok','$supplier')");

    if($insert){
        header ('location:stock.php');
    }else{
        echo'
        <script>alert("Gagal menambah barang baru");
        window.location.href="stock.php"
        </script>';
    }
}

//tambahsupplier
if(isset($_POST['tambahsupplier'])){
    $namasupplier = $_POST['namasupplier'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];

    $ceksup = mysqli_query($c,"select count(*) as jumlah from supplier where notelp='".$notelp."'");
    $ceksup = mysqli_fetch_array($ceksup);

    if($ceksup['jumlah'] == 0) {
        
        $insert = mysqli_query($c,"insert into supplier (namasupplier,alamat,notelp) values ('$namasupplier','$alamat','$notelp')");
        if($insert){
            header ('location:supplier.php');
        }else{
            echo'
            <script>alert("Gagal menambah supplier baru");
            window.location.href="supplier.php"
            </script>';
        }
    }else {
        echo'
            <script>alert("Supplier sudah terdaftar");
            window.location.href="supplier.php"
            </script>';
    }
}

//tambahpelanggan 
if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];

    $cekNoHp = mysqli_query($c,"SELECT COUNT(*) as jumlah from pelanggan WHERE notelp='".$notelp."'");
    $cekNoHp = mysqli_fetch_array($cekNoHp);

    // var_dump($cekNoHp);
    if($cekNoHp['jumlah'] == 0) {
        $insert = mysqli_query($c,"insert into pelanggan (namapelanggan,alamat,notelp) values ('$namapelanggan','$alamat','$notelp')");

        if($insert){
            echo'
            <script>alert("Data berhasil ditambahkan");
            window.location.href="pelanggan.php"
            </script>';
        }else{
            echo'
            <script>alert("Gagal menambah pelanggan baru");
            window.location.href="pelanggan.php"
            </script>';
        }
    }else{
        echo'
        <script>alert("Pelanggan sudah terdafar");
        window.location.href="pelanggan.php"
        </script>';
    }
    
    
    
}

//tambahpesanan 
if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($c,"insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if($insert){
        header ('location:index.php');
    }else{
        echo'
        <script>alert("Gagal menambah pesanan baru");
        window.location.href="index.php"
        </script>';
    }
}

//tambahproduk di view.php 
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty']; //jumlah yang mau ditampil 

    $hitung1 = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stokskrg = $hitung2['stok'];

        if ($stokskrg>=$qty){
            //kurangin stok 
            $selisih =$stokskrg-$qty;

            //hitungsubtotal 
            $get = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
            $get1= mysqli_fetch_array($get);
            $harga = $get1['harga'];
            $subtotal = $qty*$harga;

            //kalau stok cukup 
            $insert = mysqli_query($c,"insert into detailpesanan (idorder,idproduk,qty,subtotal) values ('$idp','$idproduk','$qty','$subtotal')");
            $update = mysqli_query($c,"update produk set stok='$selisih' where idproduk='$idproduk'");
            if($insert&&$update){
                header ('location:view.php?.idp='.$idp);
            }else{
                echo'
                <script>alert("Gagal menambah pesanan baru");
                window.location.href="view.php?idp='.$idp.'"
                </script>';
            }
            }else {
                echo'
                <script>alert("Stok barang tidak cukup!");
                window.location.href="view.php?idp='.$idp.'"
                </script>';
        }
    }

//barangmasuk (masuk.php)
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    $tanggal = date('Y-m-d');

    
    
    //tambahkan ke tabel produk 
    $cek = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $cek1 = mysqli_fetch_array($cek);
    $stok= $cek1['stok'];
    $totalstok= $stok+$qty;

    $cekBarang = mysqli_query($c, "SELECT count(*) as jumlah FROM masuk where idproduk='".$idproduk."' and tanggal='".$tanggal."'");
    $cekBarang = mysqli_fetch_array($cekBarang);
    // echo $cekBarang['jumlah'];

    if($cekBarang['jumlah'] == 0) {
        $insertb = mysqli_query($c,"insert into masuk(idproduk,qty) values ('$idproduk','$qty')");
    
        $update = mysqli_query($c,"update produk set stok='$totalstok' where idproduk='$idproduk'");
        if($insertb&&$update){
            header ('location:masuk.php');
        }else{
            echo'
            <script>alert("Gagal menambah barang masuk");
            window.location.href="masuk.php"
            </script>';
        }
    }else {
        echo'
        <script>alert("Data telah ada, Gunakan Edit pada tabel");
        window.location.href="masuk.php"
        </script>';
    }
}

//hapus produk diview.php
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    //cek qty skrg 
    $cek1 = mysqli_query($c,"select * from detailpesanan where iddetail='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtyskrg = $cek2['qty'];

    //cek stok skrg 
    $cek3 = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stokskrg = $cek4['stok'];

    $hitung = $stokskrg+$qtyskrg;

    $update = mysqli_query($c,"update produk set stok='$hitung' where idproduk='$idpr'");
    $hapus = mysqli_query($c,"delete from detailpesanan where idproduk='$idpr' and iddetail='$idp'");

    if($update&&$hapus){
        header ('location:view.php?.idp='.$idorder);
    }else{
        echo'
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?idp='.$idorder.'"
        </script>';
    }

}

//edit barang (stock.php)
if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];
    $supplier = $_POST['supplier'];

    $query = mysqli_query($c,"update produk set namaproduk ='$np', deskripsi='$desc', harga='$harga', supplier='$supplier' where idproduk='$idp'");

    if($query){
        header ('location:stock.php');
    }else{
        echo'
        <script>alert("Gagal mengubah data stok!");
        window.location.href="stock.php"
        </script>';
    }
}

//hapus barang (stock.php)

if(isset($_POST['deletebarang'])){
    $idp =$_POST['idp'];

    $query = mysqli_query($c,"delete from produk where idproduk='$idp'");

    if($query){
        header ('location:stock.php');
    }else{
        echo'
        <script>alert("Gagal menghapus data stok!");
        window.location.href="stock.php"
        </script>';
    }
}

//edit supplier
if(isset($_POST['editsupplier'])){
    $namasupplier = $_POST['namasupplier'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $idsupplier = $_POST['idsupplier'];

    $query = mysqli_query($c,"update supplier set namasupplier='$namasupplier', alamat='$alamat', notelp='$notelp' where idsupplier='$idsupplier'");

    if($query){
        header ('location:supplier.php');
    }else{
        echo'
        <script>alert("Gagal mengubah data supplier!");
        window.location.href="supplier.php"
        </script>';
    }
}

//hapus supplier 
if(isset($_POST['deletesupplier'])){
    $idsupplier =$_POST['idsupplier'];

    $query = mysqli_query($c,"delete from supplier where idsupplier='$idsupplier'");

    if($query){
        header ('location:supplier.php');
    }else{
        echo'
        <script>alert("Gagal menghapus data supplier!");
        window.location.href="supplier.php"
        </script>';
    }
}

//edit pelanggan 
if(isset($_POST['editpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c,"update pelanggan set namapelanggan='$namapelanggan', alamat='$alamat', notelp='$notelp' where idpelanggan='$idpl'");

    if($query){
        header ('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal mengubah data pelanggan!");
        window.location.href="pelanggan.php"
        </script>';
    }
}

//hapus pelanggan 
if(isset($_POST['deletepelanggan'])){
    $idpl =$_POST['idpl'];

    $query = mysqli_query($c,"delete from pelanggan where idpelanggan='$idpl'");

    if($query){
        header ('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal menghapus data pelanggan!");
        window.location.href="pelanggan.php"
        </script>';
    }
}

//ubah data barang masuk (masuk.php)
if(isset($_POST['editbarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari qty skrg brpa 
    $caritahu= mysqli_query($c,"select * from masuk where idmasuk='$idm'");
    $cari1= mysqli_fetch_array($caritahu);
    $qtysekarang = $cari1['qty'];

    //cari stok sekarang brpa 
    $caristok = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];


    if($qty >=$qtysekarang){
        $selisih= $qty-$qtysekarang;
        $newstok = $stoksekarang+$selisih;

        
        $query1 = mysqli_query($c,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idp'");
            if($query1&&$query2){
                header ('location:masuk.php');
            }else{
                echo'
                <script>alert("Gagal !");
                window.location.href="masuk.php"
                </script>';
            }
    }else{
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang-$selisih;

        $query1 = mysqli_query($c,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idp'");
            if($query1&&$query2){
                header ('location:masuk.php');
            }else{
                echo'
                <script>alert("Gagal Edit !");
                window.location.href="masuk.php"
                </script>';
            }
    }
    
    
}


//hapus data barang masuk (masuk.php)
if(isset($_POST['deletebarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari qty skrg brpa 
    $caritahu= mysqli_query($c,"select * from masuk where idmasuk='$idm'");
    $cari1= mysqli_fetch_array($caritahu);
    $qtysekarang = $cari1['qty'];

    //cari stok sekarang brpa 
    $caristok = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung selisih 
    $newstok = $stoksekarang-$qtysekarang;

    $query1 = mysqli_query($c,"delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idp'");
         if($query1){
             header ('location:masuk.php');
        }else{
            echo'
            <script>alert("Gagal Edit !");
            window.location.href="masuk.php"
             </script>';
         }
}

//hapus order (index.php)
if(isset($_POST['deleteorder'])){
    $ido =$_POST['ido'];

    $cekdata = mysqli_query($c,"select * from detailpesanan dp where idorder='$ido'");

    while($ok=mysqli_fetch_array($cekdata)){
        //balikkin stok
        $qty = $ok['qty'];
        $idproduk = $ok['idproduk'];
        $iddp = $ok['iddetail'];

        //caritahu data stok brpa 
        $caristok = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
        $caristok2 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok2['stok'];

        $newstok = $stoksekarang+$qty; 
        
        $queryupdate = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idproduk'");

        //hapusdata 
        $querydelete = mysqli_query($c,"delete from detailpesanan where iddetail='$iddp'");
    }

    $query = mysqli_query($c,"delete from pesanan where idorder='$ido'");

    if($queryupdate&&$querydelete&&$query){
        header ('location:index.php');
    }else{
        echo'
        <script>alert("Gagal menghapus data pesanan!");
        window.location.href="index.php"
        </script>';
    }
}

//editdetail (view.php)
if(isset($_POST['editdetail'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    //cari qty skrg brpa 
    $caritahu= mysqli_query($c,"select * from detailpesanan where iddetail='$iddp'");
    $cari1= mysqli_fetch_array($caritahu);
    $qtysekarang = $cari1['qty'];

    //cari stok sekarang brpa 
    $caristok = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];
    $harga = $caristok2['harga'];

    if($qty >=$qtysekarang){
        $selisih= $qty-$qtysekarang;
        $newstok = $stoksekarang-$selisih;
        $total = $qty*$harga;
        
        $query1 = mysqli_query($c,"update detailpesanan set qty='$qty', subtotal='$total'  where iddetail='$iddp'");
        $query2 = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idpr'");
            if($query1&&$query2){
                header ('location:view.php?idp='.$idp);
            }else{
                echo'
                <script>alert("Gagal !");
                window.location.href="view.php?idp='.$idp.'"
                </script>';
            }
    }else{
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang+$selisih;
        $total = $qty*$harga;

        $query1 = mysqli_query($c,"update detailpesanan set qty='$qty', subtotal='$total' where iddetail='$iddp'");
        $query2 = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idpr'");
            if($query1&&$query2){
                header ('location:view.php?idp='.$idp);
            }else{
                echo'
                <script>alert("Gagal Edit !");
                window.location.href="view.php?idp='.$idp.'"
                </script>';
            }
    }
    
    
}

?>