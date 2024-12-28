<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <style>
        .card-container .card {
            margin: 10px;
            width: 100%;
        }

        .card-text {
            max-height: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .card-title {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
            height: calc(1.2em * 2);
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0" style="margin-left:-200px;">
        <!-- Content Start -->
        <div class="content">
            <!-- Pengumuman Form Start -->
            <section class="section1" style="max-height: 250vh;">
                <h3 style="padding-top: 40px;">Buat Pengumuman Baru</h3>
                <div class="container-fluid pt-4 px-4 d-flex align-items-center justify-content-center" style="height: 100%;">
                    <div class="row g-4 w-100">
                        <div class="col-12">
                            <div class="bg-light rounded h-100 p-4" style="max-width: 1000px; width: 120%;" id="formContainer">
                                <h2 class="mb-4 text-center">PENGUMUMAN</h2>
                                <form id="formPengumuman" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="judulpengumuman" class="form-label">JUDUL</label>
                                        <input type="text" class="form-control" id="judulpengumuman" name="judulpengumuman" placeholder="Input judul pengumuman di sini">
                                    </div>
                                    <div class="mb-3">
                                        <label for="penulispengumuman" class="form-label">PENULIS</label>
                                        <input type="text" class="form-control" id="penulispengumuman" name="penulispengumuman" placeholder="Input penulis pengumuman di sini">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambarpengumuman" class="form-label">PILIH GAMBAR</label>
                                        <input class="form-control" type="file" id="gambarpengumuman" name="gambarpengumuman">
                                    </div>
                                    <div class="mb-3">
                                        <label for="isipengumuman" class="form-label">ISI PENGUMUMAN</label>
                                        <textarea class="form-control" placeholder="Input isi pengumuman di sini" id="isipengumuman" name="isipengumuman" style="height: 150px;"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3" id="submitButton">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Pengumuman Form End -->

            <!--Pengumuman Terdahulu -->
            <section class="section2" style="margin-top: 80px; width: 120%;">
                <h3>Pengumuman Terdahulu</h3>
                <div class="card-container">
                    <div class="row justify-content-center" id="pengumuman-list">
                        <!-- Cards will be inserted here by JavaScript -->
                    </div>
                </div>
            </section>
            <!-- Pengumuman Terdahulu End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Template Javascript -->
    <script>
        $(document).ready(function() {
            // Load pengumuman
            $.ajax({
                url: 'adm_data_pengumuman.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var container = $('#pengumuman-list');
                    $.each(data, function(index, pengumuman) {
                        // Konversi string tanggal menjadi objek Date
                        var tanggalDibuat = new Date(pengumuman.TGL_DIBUAT);
                        // Format tanggal menjadi day-month-year
                        var formattedDate = tanggalDibuat.toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        var imgSrc = pengumuman.FOTO_PENGUMUMAN ? 'data:image/jpeg;base64,' + pengumuman.FOTO_PENGUMUMAN : 'img/default.jpg';

                        var card = '<div class="col-sm-4">' +
                            '<div class="card" style="width: 18rem;">' +
                            '<img src="' + imgSrc + '" class="card-img-top" alt="' + pengumuman.JUDUL_PENGUMUMAN + '">' +
                            '<div class="card-body">' +
                            '<h5 class="card-title">' + pengumuman.JUDUL_PENGUMUMAN + '</h5>' +
                            '<p class="card-text">' + pengumuman.ISI_PENGUMUMAN + '</p>' +
                            '<p class="card-text" style="text-weight: bold;"><small class="text-muted">Dibuat oleh ' + pengumuman.PEMBUAT_PENGUMUMAN +
                            '<br>' + formattedDate + '</small></p>' +
                            '<a href="#" class="btn btn-primary lihat-selengkapnya" data-judul="' + pengumuman.JUDUL_PENGUMUMAN + '" data-penulis="' + pengumuman.PEMBUAT_PENGUMUMAN + '" data-isi="' + pengumuman.ISI_PENGUMUMAN + '">Lihat Selengkapnya</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        container.append(card);
                    });

                    // Event listener untuk "Lihat Selengkapnya"
                    $('.lihat-selengkapnya').click(function(e) {
                        e.preventDefault();
                        var judul = $(this).data('judul');
                        var penulis = $(this).data('penulis');
                        var isi = $(this).data('isi');

                        // Isi form dengan data pengumuman yang dipilih
                        $('#judulpengumuman').val(judul);
                        $('#penulispengumuman').val(penulis);
                        $('#isipengumuman').val(isi);

                        // Nonaktifkan tombol submit
                        $('#submitButton').attr('disabled', true);

                        // Scroll ke form pengumuman
                        $('html, body').animate({
                            scrollTop: $("#formContainer").offset().top
                        }, 1000); // Durasi animasi dalam milidetik (1000 = 1 detik)
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });

            // Form submit
            $('#formPengumuman').submit(function(e) {
                e.preventDefault();

                // Ambil nilai dari setiap input
                let judul = $('#judulpengumuman').val().trim();
                let penulis = $('#penulispengumuman').val().trim();
                let isi = $('#isipengumuman').val().trim();

                // Cek apakah ada data yang kosong
                if (judul === '' || penulis === '' || isi === '') {
                    alert('Harap isi semua data yang wajib (kecuali foto) sebelum submit.');
                    return;
                }

                // Konfirmasi sebelum submit
                let confirmation = confirm("Apakah Anda yakin ingin mengirim pengumuman ini? Setelah dikirim, Anda tidak bisa mengubahnya lagi. Klik 'OK' untuk melanjutkan submit, dan klik 'Cancel' untuk kembali mengedit.");
                if (!confirmation) {
                    return;
                }

                let formData = new FormData($(this)[0]);

                $.ajax({
                    url: 'adm_submit_pengumuman.php',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Response:', response);
                        try {
                            if (response.status === 'success') {
                                alert(response.message);
                                $('#formPengumuman')[0].reset();
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        } catch (e) {
                            console.error('Parsing error:', e);
                            console.error('Response:', response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>