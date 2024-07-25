<?php include 'koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Detail Pinjam
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
            <form action="<?= base_url('Detail_pinjam/proses_ubah/'.$id) ?>" method="POST">
				<div class="row">			
					<div class="col-md-6">
						<div class="mb-3">
							<label for="id_detail_pinjam" class="form-label">ID Detail Pinjam</label>
							<input type="text" class="form-control" name="id_detail_pinjam" id="id_detail_pinjam" placeholder="ID Detail_pinjam..." value="<?= $Detail_pinjam['id_detail_pinjam'] ?>" readonly>
							<input type="text" value="<?= $Detail_pinjam['id_pinjam'] ?>" name="id_pinjam" hidden>
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label  class="form-label">Nama Barang</label>
							<select class="form-control" name="id_barang" id="getIdBarang" required>
								<option value="" >Pilih Barang</option>
								<?php 
									//foreach ($barang as $data) { 
									$itembarang = mysqli_query($koneksi,"select * from barang");
									while($b = mysqli_fetch_array($itembarang)){
									?>
										<option value="<?= $b['id_barang'] ?>"<?= $b['id_barang'] == $Detail_pinjam['id_barang'] ? "selected":""?>><?= $b['nama_barang'] ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Serial Code</label>
							<select class="form-control" name="serial_code" id="showSerialCode">
								<option value="">Pilih Nomor Seri</option>
								<?php foreach ($detail_barang as $data) { ?>
									<!--<option value="<?= $data['serial_code'] ?>"<?= $data['serial_code'] == $Detail_pinjam['id_barang'] ? "selected":""?>><?= $data['serial_code'] ?></option>-->
									<option value="<?= $data['serial_code'] ?>" <?= $data['serial_code'] == $Detail_pinjam['serial_code'] ? "selected" : "" ?>>
									<?= $data['serial_code'] ?>
								</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="qtty" class="form-label">Quantity</label>
							<input type="text" class="form-control" min="0" name="qtty" id="qtty" placeholder="Masukkan Kuantitas Quantity..." value="<?= $Detail_pinjam['qtty'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="lokasi" class="form-label">lokasi</label>
							<input type="text" class="form-control" name="lokasi" id="loksai" placeholder="Masukkan lokasi..." value="<?= $Detail_pinjam['lokasi'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
							<input type="date" class="form-control" name="tgl_kembali" id="tgl_kembali" type="text" class="form-control date" placeholder="Tanggal Kembali..." value="<?= $Detail_pinjam['tgl_kembali'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="jam_kembali" class="form-label">Jam Kembali</label>
							<input type="time" class="form-control" name="jam_kembali" id="jam_kembali" placeholder="Masukkan Jam Kembali..." value="<?= $Detail_pinjam['jam_kembali'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-control" name="status" id="status" placeholder="Pilih Status...">
								<?php
								$status_options = ['Dipinjam', 'Finished'];
								foreach ($status_options as $option) {
									$selected = ($Detail_Request['status'] == $option) ? 'selected' : '';
									echo "<option value='$option' $selected>$option</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan nama Keterangan..." value="<?= $Detail_pinjam['keterangan'] ?>">
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
					
						<button class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
