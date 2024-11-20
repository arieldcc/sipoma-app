<!-- Modal Detail Kegiatan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Data Kegiatan -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Kegiatan:</strong>
                        <p id="detailNamaKegiatan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status Kegiatan:</strong>
                        <p id="detailStatusKegiatan"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Mulai:</strong>
                        <p id="detailTanggalMulai"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Selesai:</strong>
                        <p id="detailTanggalSelesai"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Deskripsi:</strong>
                        <p id="detailDeskripsi"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tempat:</strong>
                        <p id="detailTempat"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Penyelenggara:</strong>
                        <p id="detailPenyelenggara"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>File Kegiatan:</strong>
                        <div id="fileContainer">
                            <iframe id="pdfViewer" style="display: none; width: 100%; height: 400px;"></iframe>
                            <img id="imageViewer" style="display: none; width: 100%; max-height: 400px; object-fit: contain;" />
                            <a id="fileDownloadLink" href="#" target="_blank" style="display: none;">Unduh File</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
