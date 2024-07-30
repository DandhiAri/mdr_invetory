<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">
             	   Form Edit Detail Barang
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
				<form action="<?= base_url('Detail_barang/proses_tambah') ?>" method="POST">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="id_barang" class="form-label">ID Barang</label>
								<input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="id ..." value="<?= $id ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="serial_code" class="form-label">Serial Code</label>
								<input type="text" class="form-control" name="serial_code" id="serial_code" placeholder="Masukkan serial code..." >
								<!-- <input type="hidden" name="id" id="id" value="<?= $Detail_Barang['id'] ?>"> -->
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="lokasi" class="form-label">Lokasi</label>
								<input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan lokasi...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="qtty" class="form-label">Quantity</label>
								<input type="number" class="form-control" name="qtty" id="qtty" min="1">
							</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="keterangan" class="form-label">Keterangan</label>
								<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." >
							</div>
						</div>
						<div class="row">
							<div class="row float-right">
								<div class="col-md-12">
									<a href="<?= base_url('Detail_barang/init/'.$id) ?>" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
									<button type="submit" formaction="<?= base_url('Detail_barang/proses_tambah/'.$id) ?>" class="btn btn-success" id="simpan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
