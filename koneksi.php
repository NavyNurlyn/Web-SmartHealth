<?php
$con = mysqli_connect('localhost', 'root', '');
//check koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi ke database gagal: " . mysqli_connect_error();
    exit();
}
mysqli_select_db($con, 'db_smarthealth3');
