<?php

include('config/db.php');
include('classes/DB.php');
include('classes/JenisProduk.php');
include('classes/Pemasok.php');
include('classes/Produk.php');
include('classes/Template.php');

// buat instance produk
$listProduk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listProduk->open();
// tampilkan data produk
$listProduk->getProdukJoin();

// cari produk
if (isset($_POST['btn-cari'])) {
    // method mencari data produk
    $listProduk->searchProduk($_POST['cari']);
}
// sorting produk
else if (isset($_POST['sorting'])) {
    $sortingOption = $_POST['sort'];
    // sorting berdasarkan harga terendah
    if ($sortingOption == 'terendah') {
        $sort = 'ASC'; 
    } 
    // sorting berdasarkan harga tertinggi
    else {
        $sort = 'DESC'; 
    }
    $listProduk->sortProdukByHarga($sort);
}else {
    // method menampilkan data produk
    $listProduk->getProdukJoin();
}

$data = null;

// ambil data produk
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listProduk->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 produk-thumbnail">
        <a href="detail.php?id=' . $row['id_produk'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_produk'] . '" class="card-img-top" alt="' . $row['foto_produk'] . '">
            </div>
            <div class="card-body">
                <p class="card-text produk-nama my-0">' . $row['nama_produk'] .' ['. $row['nama_jenis'] . ']</p>
                <p class="card-text pemasok-nama">Rp ' . $row['harga_produk'] . '</p>
                <p class="card-text jenis_produk-nama my-0">' . $row['nama_pemasok'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listProduk->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PRODUK', $data);
$home->write();
