<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form tambah satuan barang
            </div>
        </div>
		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php endif; ?>
        <form action="<?= base_url('Satuan/proses_tambah') ?>" method="POST">
            <div class="ibox-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_satuan" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" name="nama_satuan" id="nama_satuan" placeholder="Masukkan nama barang..." required>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="row float-right">
        <div class="col-md-12">
            <a href="<?= base_url('Satuan') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
            <button type="submit" formaction="<?= base_url('Satuan/proses_tambah') ?>" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
        </div>
    </div>
    </form>
</div>
</div>
