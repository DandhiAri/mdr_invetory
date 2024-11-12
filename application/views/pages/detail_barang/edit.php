<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
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
            <form action="<?= base_url('Detail_Barang/proses_ubah/') ?>" method="POST">
           		<div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_barang" class="form-label">ID Barang</label>
							<input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="id ..." value="<?= $Detail_Barang['id_barang'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
							<?php
							$serialEmptyChecked = empty($Detail_Barang['serial_code']) ? 'checked' : '';
							?>
                            <label for="serial_code" class="form-label">Serial Code</label>
                            <input type="text" class="form-control" name="serial_code" id="serial_code" min="1" value="<?= $Detail_Barang['serial_code'] ?>" <?= $serialEmptyChecked ? 'readonly' : '' ?>>
							<div class="checkbox">
								<label style="cursor:pointer; user-select: none;">
									<input type="checkbox" id="serialEmpty" name="serialEmpty" value="-" onclick="serialEmpty()" <?= $serialEmptyChecked ?>> TIDAK ADA SERIAL CODE
									<script>
										document.getElementById('serialEmpty').addEventListener('change', function() {
											const inputField = document.getElementById('serial_code');
											const ketInputField = document.getElementById('keterangan');

											if (this.checked) {
												inputField.setAttribute('readonly', 'readonly');
												inputField.value = '';
												ketInputField.value = 'TIDAK ADA SERIAL CODE';
											} else {
												inputField.removeAttribute('readonly');
												ketInputField.value = '';
												inputField.value = '<?= $Detail_Barang['serial_code']?>';
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
							<input type="number" class="form-control" name="qtty" id="qtty" min="0" value="<?= $Detail_Barang['qtty'] ?>" placeholder="Masukkan keterangan..." required>
						</div>
					</div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan lokasi..." value="<?= $Detail_Barang['lokasi'] ?>" required>
                        </div>
                    </div>
					<div class="col-md-6">
						<label for="no_surat_pengajuan" class="form-label">Pengajuan</label>
						<select class="form-control" name="no_surat_pengajuan" id="getIdPengajuan">
							<option value="" selected="selected">Pilih Pengajuan</option>
							<?php foreach ($pengajuan as $data) { ?>
								<option value="<?= $data->no_surat ?>" <?= $data->no_surat == $Detail_Barang['no_surat_pengajuan'] ? "selected" : "" ?>>
									<?= $data->no_surat ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." value="<?= $Detail_Barang['keterangan'] ?>">
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-control" name="status" id="status" placeholder="Pilih Status..." required>
								<?php
								$status_options = ['Stored', 'In-Used'];
								foreach ($status_options as $option) {
									$selected = ($Detail_Barang['status'] == $option) ? 'selected' : '';
									echo "<option value='$option' $selected>$option</option>";
								}
								?>
							</select>
						</div>
					</div>
                </div>
				<div class="row float-right">
					<div class="col-md-12">
					<a href="<?= base_url('barang') ?>" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
						<button type="submit" formaction="<?= base_url('Detail_Barang/proses_ubah/'.$Detail_Barang['id_detail_barang']) ?>" class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
            </form>
        </div>
    </div>
