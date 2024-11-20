<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Data Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Data Pribadi -->
                <h6 class="border-bottom pb-2 mb-3">Data Pribadi</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>No Anggota:</strong>
                        <p id="detail_no_anggota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nama:</strong>
                        <p id="detail_nama"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenis Kelamin:</strong>
                        <p id="detail_j_kel"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Agama:</strong>
                        <p id="detail_agama"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Lahir:</strong>
                        <p id="detail_tanggal_lahir"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p id="detail_email"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>No Telepon:</strong>
                        <p id="detail_no_telepon"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tahun Angkatan Organisasi:</strong>
                        <p id="detail_angkatan_anggota"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Foto Anggota:</strong>
                        <div id="fileContainer">
                            <iframe id="pdfViewer" style="display: none;" width="100%" height="400px"></iframe>
                            <img id="imageViewer" style="display: none; width: 100%; max-height: 500px; object-fit: contain;" />
                            <a id="fileDownloadLink" href="#" target="_blank" class="btn btn-primary mt-2" style="display: none;">Unduh Foto</a>
                        </div>
                    </div>
                </div>

                <!-- Data Alamat -->
                <h6 class="border-bottom pb-2 mb-3 mt-4">Data Alamat</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Alamat Jalan:</strong>
                        <p id="detail_alamat_jalan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kelurahan:</strong>
                        <p id="detail_alamat_kelurahan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kecamatan:</strong>
                        <p id="detail_alamat_kecamatan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kota:</strong>
                        <p id="detail_alamat_kota"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Provinsi:</strong>
                        <p id="detail_alamat_provinsi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kode Pos:</strong>
                        <p id="detail_kode_pos"></p>
                    </div>
                </div>

                <!-- Data Kampus -->
                <h6 class="border-bottom pb-2 mb-3 mt-4">Data Kampus</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Kampus:</strong>
                        <p id="detail_kampus"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Program Studi:</strong>
                        <p id="detail_program_studi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tahun Angkatan Mahasiswa:</strong>
                        <p id="detail_angkatan_mahasiswa"></p>
                    </div>
                </div>

                <!-- Data Keanggotaan -->
                <h6 class="border-bottom pb-2 mb-3 mt-4">Data Keanggotaan</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status Keanggotaan:</strong>
                        <p id="detail_status_keanggotaan"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Bergabung:</strong>
                        <p id="detail_tanggal_bergabung"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Keluar:</strong>
                        <p id="detail_tanggal_keluar"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Keterangan:</strong>
                        <p id="detail_keterangan_keanggotaan"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
