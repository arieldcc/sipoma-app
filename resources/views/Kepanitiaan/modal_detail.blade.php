<!-- Modal untuk Detail Kepanitiaan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Kepanitiaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Foto Anggota -->
                <div class="text-center mb-4">
                    <img id="detailFotoAnggota" src="" alt="Foto Anggota" class="img-fluid rounded" style="max-width: 150px; display: none;">
                </div>

                <!-- Data Anggota -->
                <h6>Data Panitia</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nomor Anggota:</strong>
                        <p id="detailNoAnggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nama:</strong>
                        <p id="detailNamaAnggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kampus:</strong>
                        <p id="detailKampus"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status Keanggotaan:</strong>
                        <p id="detailStatusKeanggotaan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jabatan dalam Panitia:</strong>
                        <p id="detailJabatanPanitia"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Tugas:</strong>
                        <p id="detailTugasPanitia"></p>
                    </div>
                </div>

                <!-- Data Kegiatan -->
                <h6>Data Kegiatan</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Kegiatan:</strong>
                        <p id="detailNamaKegiatan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tempat:</strong>
                        <p id="detailTempatKegiatan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Penyelenggara:</strong>
                        <p id="detailPenyelenggaraKegiatan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Waktu Pelaksanaan:</strong>
                        <p id="detailWaktuKegiatan"></p>
                    </div>
                    <div class="col-md-12 text-center">
                        <!-- Tempat untuk menampilkan gambar atau PDF kegiatan -->
                        <iframe id="fileKegiatanPDF" src="" style="display: none; width: 100%; height: 300px;" frameborder="0"></iframe>
                        <img id="fileKegiatanImage" src="" alt="Gambar Kegiatan" class="img-fluid" style="display: none; max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
