<?php
require '../function.php';

usleep(500000);

// Ambil kata kunci pencarian dari parameter GET
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Menggunakan function cari
$mahasiswa = cari($keyword);
?>

<!-- Hasil Pencarian dalam Bentuk Tabel -->
<table class="table-responsive">
    <!-- ... kode table header ... -->
    <?php $i = 1 ?>
    <?php foreach ($mahasiswa as $row) : ?>
        <tr>
            <td><?= $i ?></td>
            <td class="actions">
                <a href="edit.php?id=<?= $row->_id ?>" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="hapus.php?id=<?= $row->_id ?>" class="btn-delete" onclick="return confirm('Apakah yakin untuk menghapus data ini?')">
                    <i class="fas fa-trash-alt"></i> Hapus
                </a>
            </td>
            <td><img src="img/<?= $row->foto ?>" alt="Foto <?= $row->nama ?>" width="50"></td>
            <td><?= $row->nim ?></td>
            <td><?= $row->nama ?></td>
            <td><?= $row->email ?></td>
            <td><?= $row->jurusan ?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
</table>