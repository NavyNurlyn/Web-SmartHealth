<?php
include("koneksi.php");

if (isset($_POST['id_antrian'])) {
  $id_antrian = $_POST['id_antrian'];
  $sql = "UPDATE antrian SET STATUS = '4' WHERE ID_ANTRIAN = '$id_antrian'";
  if (mysqli_query($con, $sql)) {
    echo "<script>
                alert('Antrian berhasil dibatalkan.');
                window.location.href = 'batalkan-antrian.php?nik=" . $_POST['nik'] . "';
              </script>";
  } else {
    echo "<script>
                alert('Gagal membatalkan antrian: " . mysqli_error($con) . "');
                window.location.href = 'batalkan-antrian.php?nik=" . $_POST['nik'] . "';
              </script>";
  }
}
