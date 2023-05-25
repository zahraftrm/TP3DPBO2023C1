<?php

include('config/db.php');
include('classes/DB.php');
include('classes/JenisProduk.php');
include('classes/Pemasok.php');
include('classes/Produk.php');
include('classes/Template.php');

$produk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$produk->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $produk->getProdukById($id);
        $row = $produk->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_produk'] . '" class="img-thumbnail" alt="' . $row['foto_produk'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Kode Produk</td>
                                    <td>:</td>
                                    <td>' . $row['kode_produk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['nama_produk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Merek</td>
                                    <td>:</td>
                                    <td>' . $row['merek_produk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>Rp ' . $row['harga_produk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td>:</td>
                                    <td>' . $row['nama_jenis'] . '</td>
                                </tr>
                                <tr>
                                    <td>Pemasok</td>
                                    <td>:</td>
                                    <td>' . $row['nama_pemasok'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="tambah.php?id=' . $row['id_produk'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="tambah.php?hapus=' . $row['id_produk'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($produk->deleteProduk($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'detail.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'detail.php';
            </script>";
        }
    }
}

$produk->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PRODUK', $data);
$detail->write();
