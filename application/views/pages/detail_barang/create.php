<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">
             	   Form Create Detail Barang
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
					<div class="row">
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
								<div class="checkbox" >
									<label style="cursor:pointer; user-select: none;">
										<input  type="checkbox" id="serialEmpty" name="serialEmpty" value="-" onclick="serialEmpty()"> TIDAK ADA SERIAL CODE
										<script>
											document.getElementById('serialEmpty').addEventListener('change', function() {
												const inputField = document.getElementById('serial_code');
												const ketInputField = document.getElementById('keterangan');

												if (this.checked) {
													inputField.setAttribute('readonly', 'readonly');
													ketInputField.value = 'TIDAK ADA SERIAL CODE';
												} else {
													inputField.removeAttribute('readonly');
													ketInputField.value = '';
												}
											});
										</script>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="qtty" class="form-label">Quantity</label>
								<input type="number" class="form-control" name="qtty" id="qtty" min="0" placeholder="Masukkan keterangan...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="lokasi" class="form-label">Lokasi</label>
								<input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan lokasi...">
							</div>
						</div>
						<div class="col-md-6">
							<label for="Pengajuan" class="form-label">Pengajuan</label><br>
							<div class="input-group">
								<select class="form-control" name="id_pengajuan" id="">
									<option value="" >Pilih ID pengajuan</option>
									<?php foreach ($pengajuan as $b){ ?>
										<option value="<?= $b->id_pengajuan ?>"><?= $b->id_pengajuan ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="keterangan" class="form-label">Keterangan</label>
								<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." >
						</div>
					</div>
					<div class="row float-right">
						<div class="col-md-12">
							<a href="<?= base_url('barang') ?>" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
							<button type="submit" formaction="<?= base_url('Detail_barang/proses_tambah/'.$id) ?>" class="btn btn-success" id="simpan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
