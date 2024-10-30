<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Request
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
            <form id="add-request" action="<?= base_url('Request/proses_tambah') ?>" method="POST">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama PIC Request</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama..." required>
							<?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
							
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="mb-3">
                            <label for="tgl_request" class="form-label">Tanggal Request</label>
                            <input type="date" class="form-control" name="tgl_request" id="tgl_request" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Request</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan...">
                        </div>
					</div>
                </div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('request') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" formaction="<?= base_url('Request/proses_tambah') ?>" class="btn btn-success" id="simpan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
</div>
