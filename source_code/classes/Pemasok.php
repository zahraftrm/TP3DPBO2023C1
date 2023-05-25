<?php

class Pemasok extends DB
{
    function getPemasok()
    {
        $query = "SELECT * FROM pemasok";
        return $this->execute($query);
    }

    function getPemasokById($id)
    {
        $query = "SELECT * FROM pemasok WHERE id_pemasok=$id";
        return $this->execute($query);
    }

    function addPemasok($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO pemasok VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updatePemasok($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE pemasok SET nama_pemasok='$nama' WHERE id_pemasok=$id";
        return $this->executeAffected($query);
    }

    function deletePemasok($id)
    {
        $query = "DELETE FROM pemasok WHERE id_pemasok=$id";
        return $this->executeAffected($query);
    }
}
