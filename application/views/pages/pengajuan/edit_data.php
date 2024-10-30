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
                            <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" value="<?= $Pengajuan['tgl_pengajuan'] ?>" class="form-control" name="tgl_pengajuan" id="tgl_pengajuan">
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="invoice" class="form-label">Bukti Invoice Pengajuan</label>
							<?php if(!empty($Pengajuan['invoice'])){ ?>
								<br><b>Bukti Invoice Pengajuan terakhir : <b><?= $Pengajuan['invoice'] ?></b></b>
							<?php }else{ ?>
								<p>Data ini tidak punya bukti invoice pengajuan.</p>
							<?php } ?>
							<input type="file" class="form-control" size="20" name="invoice" id="invoice">
							<p style="font-size:13px;">requirement type file upload : <b>jpg, jpeg dan png</b> </p>
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('Pengajuan') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
