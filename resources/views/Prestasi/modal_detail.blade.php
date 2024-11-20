<!-- Modal untuk Detail Prestasi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Foto Prestasi -->
                <div class="text-center mb-4" id="previewContainer" style="display: none;">
                    <div id="imagePreview" style="display: none;">
                        <img id="detailFotoPrestasi" src="" alt="Foto Prestasi" class="img-fluid rounded" style="max-width: 400px;">
                    </div>
                    <div id="pdfPreview" style="display: none;">
                        <iframe id="detailPdfPrestasi" src="" width="100%" height="500px"></iframe>
                    </div>
                </div>

                <!-- Data Prestasi -->
                <h6>Data Prestasi</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Prestasi:</strong>
                        <p id="detailNamaPrestasi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenis Prestasi:</strong>
                        <p id="detailJenisPrestasi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal:</strong>
                        <p id="detailTanggal"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Deskripsi Prestasi:</strong>
                        <p id="detailKeterangan"></p>
                    </div>
                </div>

                <!-- Data Anggota -->
                <h6>Data Anggota</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nomor Anggota:</strong>
                        <p id="detailNoAnggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nama Anggota:</strong>
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
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
