<?php

include('config/db.php');
include('classes/DB.php');
include('classes/JenisProduk.php');
include('classes/Template.php');

$jenis = new JenisProduk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jenis->open();
$jenis->getJenisProduk();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($jenis->addJenisProduk($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'jenisProduk.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'jenisProduk.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Jenis Produk';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Jenis Produk</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Jenis';

while ($div = $jenis->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_jenis'] . '</td>
    <td style="font-size: 22px;">
        <a href="jenisProduk.php?id=' . $div['id_jenis'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="jenis.php?hapus=' . $div['id_jenis'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($jenis->updateJenisProduk($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'jenisProduk.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'jenisProduk.php';
            </script>";
            }
        }

        $jenis->getJenisProdukById($id);
        $row = $jenis->getResult();

        $dataUpdate = $row['nama_jenis'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($jenis->deleteJenisProduk($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'jenisProduk.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'jenisProduk.php';
            </script>";
        }
    }
}

$jenis->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
