<?php

class Produk extends DB
{
    function getProdukJoin()
    {
        $query = "SELECT * FROM produk JOIN jenis_produk ON produk.id_jenis=jenis_produk.id_jenis JOIN pemasok ON produk.id_pemasok=pemasok.id_pemasok ORDER BY produk.id_produk";

        return $this->execute($query);
    }

    function getProduk()
    {
        $query = "SELECT * FROM produk";
        return $this->execute($query);
    }

    function getProdukById($id)
    {
        $query = "SELECT * FROM produk JOIN jenis_produk ON produk.id_jenis=jenis_produk.id_jenis JOIN pemasok ON produk.id_pemasok=pemasok.id_pemasok WHERE id_produk=$id";
        return $this->execute($query);
    }

   function searchProduk($keyword)
   {
        // Query searching dengan keyword nama produk yg fleksibel dan dapat menampilkan data kode_jenis dari table jenis_produk dan toko_pemasok dari table pemasok
        $query = "SELECT p.*, j.nama_jenis, ps.nama_pemasok FROM produk p
                  LEFT JOIN jenis_produk j ON p.id_jenis = j.id_jenis
                  LEFT JOIN pemasok ps ON p.id_pemasok = ps.id_pemasok
                  WHERE p.nama_produk LIKE '%$keyword%'";
        // Kode untuk menjalankan query dan mengembalikan hasilnya
        return $this->execute($query);
    }

    function sortProdukByHarga($sort)
    {
        $query = "SELECT p.*, j.nama_jenis, ps.nama_pemasok FROM produk p
                  LEFT JOIN jenis_produk j ON p.id_jenis = j.id_jenis
                  LEFT JOIN pemasok ps ON p.id_pemasok = ps.id_pemasok
                  ORDER BY p.harga_produk $sort";
        return $this->execute($query);
    }

    function addProduk($data, $file)
    {
        $kode = $data['kode_produk'];
        $nama = $data['nama_produk'];
        $merek = $data['merek_produk'];
        $foto = $data['foto_produk'];
        $harga = $data['harga_produk'];
        $id_jenis = $data['id_jenis'];
        $id_pemasok = $data['id_pemasok'];
        $query = "INSERT INTO produk VALUES('', '$kode', '$nama', '$merek', '$foto', '$harga', '$id_jenis, '$id_pemasok')";
        return $this->executeAffected($query);
    }

    function updateProduk($id, $data, $file)
    {
        $kode = $data['kode_produk'];
        $nama = $data['nama_produk'];
        $merek = $data['merek_produk'];
        $foto = $data['foto_produk'];
        $harga = $data['harga_produk'];
        $id_jenis = $data['id_jenis_produk'];
        $id_pemasok = $data['id_pemasok_produk'];
        $query = "UPDATE produk SET kode_produk='$kode', nama_produk='$nama', merek_produk='$merek', foto_produk='$foto', harga_produk='$harga', id_jenis='$id_jenis', id_pemasok='$id_pemasok' WHERE id_produk=$id";
        return $this->executeAffected($query);
    }

    function deleteProduk($id)
    {
        $query = "DELETE FROM produk WHERE id_produk=$id";
        return $this->executeAffected($query);
    }
}
