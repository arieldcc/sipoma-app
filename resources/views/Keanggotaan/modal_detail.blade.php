<!-- Modal untuk Detail Keanggotaan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Keanggotaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Foto Anggota -->
                <div class="text-center mb-4">
                    <img id="detailFotoAnggota" src="" alt="Foto Anggota" class="img-fluid rounded" style="max-width: 150px; display: none;">
                </div>

                <!-- Data Anggota -->
                <h6>Data Anggota</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Anggota:</strong>
                        <p id="detailNamaAnggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nomor Anggota:</strong>
                        <p id="detailNoAnggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kampus:</strong>
                        <p id="detailKampus"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Program Studi:</strong>
                        <p id="detailProgramStudi"></p>
                    </div>
                </div>

                <!-- Data Keanggotaan -->
                <h6>Data Keanggotaan</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status Keanggotaan:</strong>
                        <p id="detailStatusKeanggotaan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Bergabung:</strong>
                        <p id="detailTanggalBergabung"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Keluar:</strong>
                        <p id="detailTanggalKeluar"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Keterangan:</strong>
                        <p id="detailKeterangan"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
