<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Request
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
            <form action="<?= base_url('Request/proses_ubah/'.$id)?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama barang..." value="<?= $Request['nama'] ?>"> 
                            <input type="hidden" name="id_request" id="id_request" value="<?= $Request['id_request'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_request" class="form-label">Tanggal Request</label>
                            <input type="date" class="form-control" name="tgl_request" id="tgl_request" value="<?= $Request['tgl_request'] ?>">
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="mb-3">
							<?php
							if (isset($Request['no_surat'])){
								$code = $Request['no_surat'];
								$no_surat = substr($code, 7, 3);
							} else {
								$no_surat = null;
							}
							?>
							<label for="tgl_replace_update" class="form-label">Custom ID Nomer Surat</label>
							<?php if($Request['no_surat'] !== null){ ?>
								<p style="font-size:12px;">ID Nomer Surat Sekarang = <b><?= $Request['no_surat'] ?></b></p>
							<?php } else { ?>
								<p style="font-size:12px;"><b>SURAT JALAN BELUM ADA</b></p>
							<?php } ?>
							<input type="text" pattern="[0-9]*" class="form-control" value="<?= $no_surat ?>" name="no_surat" id="no_surat">
							<p style="font-size:13px;">Contoh ID nomer surat :MDR-DN-<b>XXX</b>-SC-XI-24. (Kosongkan jika ingin menghapus ID)</p>
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('Request') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
