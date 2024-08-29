<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form tambah pinjam
            </div>
        </div>
		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php endif; ?>
        <form action="<?= base_url('Pinjam/proses_tambah') ?>" method="POST">
            <div class="ibox-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" name="nama_peminjam" id="nama_peminjam" placeholder="Masukkan Nama Peminjam...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Masukkan Nama Penerima...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_pemberi" class="form-label">Nama Pemberi</label>
                            <input type="text" class="form-control" name="nama_pemberi" id="nama_pemberi" placeholder="Masukkan Nama Pemberi...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="wkt_pinjam" class="form-label">Tgl Pinjam</label>
                            <input type="datetime-local" class="form-control" name="wkt_pinjam" id="wkt_pinjam" placeholder="Masukkan Tgl Pinjam...">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan...">
                        </div>
                    </div>
                </div>
            </div>
			<div class="row float-right">
				<div class="col-md-12">
					<a href="<?= base_url('Pinjam') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
					<button type="submit" formaction="<?= base_url('Pinjam/proses_tambah') ?>" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
				</div>
			</div>
		</form>
    </div>
</div>
