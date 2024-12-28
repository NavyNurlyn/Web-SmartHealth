<!-- Daftar Harian Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Pendaftar Poli</h6>
                    <a href="admin.php?page=riwayat">Show All</a>
                </div>
                <div>
                    <p><?php
                        date_default_timezone_set('Asia/Jakarta');

                        // Set locale to Indonesian for the day and month names
                        setlocale(LC_TIME, 'id_ID', 'id_ID.UTF-8', 'Indonesian_Indonesia.1252', 'Indonesian');

                        // Format the date in Indonesian
                        echo strftime("%A, %d %B %Y");
                        ?></p>

                </div>
                <div id="pendaftar-poli-chart" style="height: 300px;"></div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-6">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Pendaftar Harian</h6>
                    <a href="admin.php?page=riwayat">Show All</a>
                </div>
                <div>
                    <p>Pendaftaran 7 hari terakhir</p>
                </div>
                <div id="pendaftar-harian-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<!-- Daftar Harian End -->

<!-- Antrian Terbaru Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Antrian Terbaru Hari Ini</h6>
            <a href="admin.php?page=riwayat">Show All</a>
        </div>
        <?php include('adm_data_terbaru.php'); ?>
    </div>
</div>
<!-- Antrian Terbaru End -->