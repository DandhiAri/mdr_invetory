<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Barang
                <!-- <?php
                
        echo var_dump($Barang);
                ?> -->
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
            <form action="<?= base_url('Barang/proses_ubah/'). $id ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Masukkan nama barang..." value="<?= $Barang['nama_barang'] ?>"> 
                            <input type="hidden" name="id_barang" id="id_barang" value="<?= $Barang['id_barang'] ?>">
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="id_jenis" class="form-label">Jenis</label>
							<select class="form-control" name="id_jenis" id="id_jenis">
								<option value="" selected="selected" disabled="disabled">Pilih Jenis</option>
								<?php foreach ($jenis as $data) { ?>
									<option value="<?= $data['id_jenis'] ?>" <?= $data['id_jenis'] == $Barang['id_jenis'] ? "selected" : "" ?>>
										<?= $data['nama_jenis'] ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="id_satuan" class="form-label">Satuan</label>
							<select class="form-control" name="id_satuan" id="id_satuan">
								<option value="" selected="selected" disabled="disabled">Pilih Satuan</option>
								<?php foreach ($satuan as $data) { ?>
									<option value="<?= $data['id_satuan'] ?>" <?= $data['id_satuan'] == $Barang['id_satuan'] ? "selected" : "" ?>>
										<?= $data['nama_satuan'] ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('Barang') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
</div>
