<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Pemasok.php');
include('classes/Template.php');

$pemasok = new Pemasok($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pemasok->open();
$pemasok->getPemasok();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($pemasok->addPemasok($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'pemasok.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'pemasok.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Pemasok';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Pemasok</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Pemasok';

while ($div = $pemasok->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_pemasok'] . '</td>
    <td style="font-size: 22px;">
        <a href="pemasok.php?id=' . $div['id_pemasok'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="pemasok.php?hapus=' . $div['id_pemasok'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($pemasok->updatePemasok($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'pemasok.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'pemasok.php';
            </script>";
            }
        }

        $pemasok->getPemasokById($id);
        $row = $pemasok->getResult();

        $dataUpdate = $row['nama_pemasok'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($pemasok->deletePemasok($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'pemasok.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'pemasok.php';
            </script>";
        }
    }
}

$pemasok->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
