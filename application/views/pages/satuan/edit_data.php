<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form edit satuan barang
            </div>
        </div>
		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php endif; ?>
        <div class="ibox-body">
            <form action="<?= base_url('Satuan/proses_ubah') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_satuan" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" name="nama_satuan" id="nama_satuan" placeholder="Masukkan nama barang..." value="<?= $Satuan['nama_satuan'] ?>" required>
                            <input type="hidden" name="id_satuan" id="id_satuan" value="<?= $Satuan['id_satuan'] ?>">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="row float-right">
        <div class="col-md-12">
            <a href="<?= base_url('Satuan') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
            <button type="submit" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
        </div>
    </div>
    </form>

</div>
</div>
