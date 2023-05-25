<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Produk.php');
include('classes/Template.php');

$produk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$produk->open();
$produk->getProduk();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($produk->addProduk($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'tambah.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintambah.html');

$mainTitle = 'Produk';

$data = null;
$no = 1;
$formLabel = 'Produk';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($produk->updateProduk($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'tambah.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'tambah.php';
            </script>";
            }
        }

        $produk->getProdukById($id);
        $row = $produk->getResult();

        $dataUpdate1 = $row['kode_produk'];
        $dataUpdate2 = $row['nama_produk'];
        $dataUpdate3 = $row['merek_produk'];
        $dataUpdate4 = $row['foto_produk'];
        $dataUpdate5 = $row['harga_produk'];
        $dataUpdate6 = $row['id_jenis'];
        $dataUpdate7 = $row['id_pemasok'];

        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_KODE', $dataUpdate1);
        $view->replace('DATA_VAL_NAMA', $dataUpdate2);
        $view->replace('DATA_VAL_MEREK', $dataUpdate3);
        $view->replace('DATA_VAL_FOTO', $dataUpdate4);
        $view->replace('DATA_VAL_HARGA', $dataUpdate5);
        $view->replace('DATA_VAL_JENIS', $dataUpdate6);
        $view->replace('DATA_VAL_PEMASOK', $dataUpdate7);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($produk->deleteProduk($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$produk->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
