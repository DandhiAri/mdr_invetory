<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Barang
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
            <form action="<?= base_url('Barang/proses_tambah') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 <?= form_error('nama_barang') ? 'has-error' : '' ?>">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" value="<?= set_value('nama_barang') ?>" name="nama_barang" id="nama_barang" placeholder="Masukkan nama barang..." required> 
							<span><?= form_error('nama_barang') ?></span>
						</div>
                    </div>
					 <div class="col-md-6">
                        <div class="mb-3 <?= form_error('id_jenis') ? 'has-error' : '' ?>">
                            <label for="id_jenis" class="form-label">Jenis</label>
                            <select class="form-control" name="id_jenis" id="id_jenis" required>
                                <option value="">Pilih Jenis</option>
                                <?php foreach ($jenis as $data) { ?>
                                    <option value="<?= $data['id_jenis'] ?>"><?= $data['nama_jenis'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="mb-3 <?= form_error('id_satuan') ? 'has-error' : '' ?>">
                            <label for="id_satuan" class="form-label">Satuan</label>
                            <select class="form-control" name="id_satuan" id="id_satuan" required>
                                <option value="">Pilih Satuan</option>
                                <?php foreach ($satuan as $data) { ?>
                                    <option value="<?= $data['id_satuan'] ?>"><?= $data['nama_satuan'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="row float-right">
					<div class="col-md-12" style="margin-left:3em;">
						<a href="<?= base_url('Barang') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" formaction="<?= base_url('Barang/proses_tambah') ?>" class="btn btn-success" id="simpanbarang" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
</div>
