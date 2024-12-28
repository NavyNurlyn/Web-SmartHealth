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
            <!-- Artikel Form Start -->
            <section class="section1" style="max-height: 250vh;">
                <h3 style="padding-top: 40px;">Buat Artikel Kesehatan Baru</h3>
                <div class="container-fluid pt-4 px-4 d-flex align-items-center justify-content-center" style="height: 100%;">
                    <div class="row g-4 w-100">
                        <div class="col-12">
                            <div class="bg-light rounded h-100 p-4" style="max-width: 1000px; width: 120%;" id="formContainer">
                                <h2 class="mb-4 text-center">ARTIKEL KESEHATAN</h2>
                                <form id="formArtikel" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="judulartikel" class="form-label">JUDUL</label>
                                        <input type="text" class="form-control" id="judulartikel" name="judulartikel" placeholder="Input judul artikel di sini">
                                    </div>
                                    <div class="mb-3">
                                        <label for="penulisartikel" class="form-label">PENULIS</label>
                                        <input type="text" class="form-control" id="penulisartikel" name="penulisartikel" placeholder="Input penulis artikel di sini">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambarartikel" class="form-label">PILIH GAMBAR</label>
                                        <input class="form-control" type="file" id="gambarartikel" name="gambarartikel">
                                    </div>
                                    <div class="mb-3">
                                        <label for="isiartikel" class="form-label">ISI ARTIKEL</label>
                                        <textarea class="form-control" placeholder="Input isi artikel di sini" id="isiartikel" name="isiartikel" style="height: 150px;"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3" id="submitButton">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Artikel Form End -->

            <!-- Artikel Terdahulu -->
            <section class="section2" style="margin-top: 80px; width: 120%;">
                <h3>Artikel Terdahulu</h3>
                <div class="card-container">
                    <div class="row justify-content-center" id="artikel-list">
                        <!-- Cards will be inserted here by JavaScript -->
                    </div>
                </div>
            </section>
            <!-- Artikel Terdahulu End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Template Javascript -->
    <script>
        $(document).ready(function() {
            // Load artikel
            $.ajax({
                url: 'adm_data_artikel.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var container = $('#artikel-list');
                    $.each(data, function(index, artikel) {
                        var tanggalDibuat = new Date(artikel.TGL_ARTIKEL);
                        var formattedDate = tanggalDibuat.toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        var imgSrc = artikel.FOTO_ARTIKEL ? 'data:image/jpeg;base64,' + artikel.FOTO_ARTIKEL : 'img/default.jpg';

                        var card = '<div class="col-sm-4">' +
                            '<div class="card" style="width: 18rem;">' +
                            '<img src="' + imgSrc + '" class="card-img-top" alt="' + artikel.JUDUL_ARTIKEL + '">' +
                            '<div class="card-body">' +
                            '<h5 class="card-title">' + artikel.JUDUL_ARTIKEL + '</h5>' +
                            '<p class="card-text">' + artikel.ISI_ARTIKEL + '</p>' +
                            '<p class="card-text" style="text-weight: bold;"><small class="text-muted">Dibuat oleh ' + artikel.PENULIS_ARTIKEL +
                            '<br>' + formattedDate + '</small></p>' +
                            '<a href="#" class="btn btn-primary lihat-selengkapnya" data-judul="' + artikel.JUDUL_ARTIKEL + '" data-penulis="' + artikel.PENULIS_ARTIKEL + '" data-isi="' + artikel.ISI_ARTIKEL + '">Lihat Selengkapnya</a>' +
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

                        // Isi form dengan data artikel yang dipilih
                        $('#judulartikel').val(judul);
                        $('#penulisartikel').val(penulis);
                        $('#isiartikel').val(isi);

                        // Nonaktifkan tombol submit
                        $('#submitButton').attr('disabled', true);

                        // Scroll ke form artikel
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
            $('#formArtikel').submit(function(e) {
                e.preventDefault();

                let judul = $('#judulartikel').val().trim();
                let penulis = $('#penulisartikel').val().trim();
                let isi = $('#isiartikel').val().trim();

                if (judul === '' || penulis === '' || isi === '') {
                    alert('Harap isi semua data yang wajib (kecuali foto) sebelum submit.');
                    return;
                }

                let confirmation = confirm("Apakah Anda yakin ingin mengirim artikel ini? Setelah dikirim, Anda tidak bisa mengubahnya lagi. Klik 'OK' untuk melanjutkan submit, dan klik 'Cancel' untuk kembali mengedit.");
                if (!confirmation) {
                    return;
                }

                let formData = new FormData($(this)[0]);

                $.ajax({
                    url: 'adm_submit_artikel.php',
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
                                $('#formArtikel')[0].reset();
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