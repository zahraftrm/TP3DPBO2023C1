<?php

class JenisProduk extends DB
{
    function getJenisProduk()
    {
        $query = "SELECT * FROM jenis_produk";
        return $this->execute($query);
    }

    function getJenisProdukById($id)
    {
        $query = "SELECT * FROM jenis_produk WHERE id_jenis=$id";
        return $this->execute($query);
    }

    function addJenisProduk($data)
    {
        $nama = $data['nama_jenis'];
        $query = "INSERT INTO jenis_produk VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updateJenisProduk($id, $data)
    {
        $nama = $data['nama_jenis'];
        $query = "UPDATE jenis_produk SET nama_jenis='$nama' WHERE id_jenis=$id";
        return $this->executeAffected($query);
    }

    function deleteJenisProduk($id)
    {
        $query = "DELETE FROM jenis_produk WHERE id_jenis=$id";
        return $this->executeAffected($query);
    }
}