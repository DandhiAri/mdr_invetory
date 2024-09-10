<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Jenis Barang
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
            <form action="<?= base_url('Jenis/proses_tambah_jenis')?>" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">Jenis Barang</label>
                        <input type="text" class="form-control" name="nama_jenis" id="nama_jenis" placeholder="Masukkan Jenis Barang..." required>
                    </div>
                    <div class="row">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <a href="<?= base_url('Jenis') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
                                <button type="submit" formaction="<?=base_url('Jenis/proses_tambah_jenis')?>" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                            </div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
