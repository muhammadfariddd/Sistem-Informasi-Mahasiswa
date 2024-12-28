<?php
require_once __DIR__ . '/vendor/autoload.php';
require "function.php";

$mahasiswa = getAllMahasiswa();

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="style/print.css">
</head>
<body>
    <h1>Daftar Mahasiswa</h1>

    <table class="table-responsive">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>';


$i = 1;
foreach ($mahasiswa as $row) {
    $html .= '
                <tr>
                <td>' . $i . '</td>
                <td><img src="img/' . $row->foto . '" alt="Foto' . $row->nama . '" width="50"></td>
                <td>' . $row->nim . '</td>
                <td>' . $row->nama . '</td>
                <td>' . $row->email . '</td>
                <td>' . $row->jurusan . '</td>
                </tr>
            ';
    $i++;
}

$html .= '</table>
    </body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('daftar-mahasiswa.pdf', 'I');
