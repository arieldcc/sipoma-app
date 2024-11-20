<!-- Modal untuk Detail Keuangan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Data Keuangan -->
                <h6>Data Transaksi</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Transaksi:</strong>
                        <p id="detailNamaTransaksi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Transaksi:</strong>
                        <p id="detailTanggalTransaksi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenis Transaksi:</strong>
                        <p id="detailJenisTransaksi"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jumlah:</strong>
                        <p id="detailJumlah"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Sumber Dana:</strong>
                        <p id="detailSumberDana"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Keterangan:</strong>
                        <p id="detailKeterangan"></p>
                    </div>
                </div>

                <!-- File Bukti Transaksi -->
                <h6>Bukti Transaksi</h6>
                <div class="text-center">
                    <iframe id="detailBuktiTransaksiPDF" src="" style="display: none; width: 100%; height: 500px; border: none;"></iframe>
                    <img id="detailBuktiTransaksiImg" src="" alt="Bukti Transaksi" class="img-fluid" style="display: none; max-width: 100%; height: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
