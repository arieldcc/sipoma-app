<!-- Modal Detail Pengurus -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Data Anggota -->
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="detailFotoAnggota" src="" alt="Foto Anggota" class="img-fluid rounded mb-3" style="max-width: 150px;">
                    </div>
                    <div class="col-md-8">
                        <h6>Data Anggota</h6>
                        <p><strong>Nomor Anggota:</strong> <span id="detailNoAnggota"></span></p>
                        <p><strong>Nama Anggota:</strong> <span id="detailNamaAnggota"></span></p>
                        <p><strong>Kampus:</strong> <span id="detailKampus"></span></p>
                        <p><strong>Program Studi:</strong> <span id="detailProgramStudi"></span></p>
                    </div>
                </div>
                <hr>

                <!-- Data Keanggotaan -->
                <div class="row">
                    <div class="col-md-12">
                        <h6>Data Keanggotaan</h6>
                        <p><strong>Status Keanggotaan:</strong> <span id="detailStatusKeanggotaan"></span></p>
                        <p><strong>Tanggal Bergabung:</strong> <span id="detailTanggalBergabung"></span></p>
                    </div>
                </div>
                <hr>

                <!-- Data Pengurus -->
                <div class="row">
                    <div class="col-md-12">
                        <h6>Data Pengurus</h6>
                        <p><strong>Jabatan:</strong> <span id="detailJabatan"></span></p>
                        <p><strong>Periode Mulai:</strong> <span id="detailPeriodeMulai"></span></p>
                        <p><strong>Periode Selesai:</strong> <span id="detailPeriodeSelesai"></span></p>
                        <p><strong>Status Pengurus:</strong> <span id="detailStatusPengurus"></span></p>
                        <p><strong>Keterangan:</strong> <span id="detailKeterangan"></span></p>
                    </div>
                </div>

                <!-- Data Periode -->
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6>Data Periode</h6>
                        <p><strong>Periode:</strong> <span id="detailPeriode"></span></p>
                        <p><strong>Status Periode:</strong> <span id="detailStatusPeriode"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
