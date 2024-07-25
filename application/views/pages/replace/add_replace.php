
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Data Replace
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
            <form action="<?= base_url('Replace/proses_tambah_replace')?>" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="nama" class="form-label">PIC</label>
							<input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama...">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="tgl_replace" class="form-label">Tanggal Replace</label>
							<input type="date" class="form-control" name="tgl_replace" id="tgl_replace" value="<?= date('Y-m-d')?>">
						</div>
					</div>
					<div class="col-md-6">
							<div class="mb-3">
								<label for="keterangan" class="form-label">Keterangan</label>
								<input type="text" class="form-control" name="keterangan" id="nama" placeholder="Masukkan Keterangan...">
							</div>
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('replace') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
			</form>	
        </div>
    </div>
</div>
