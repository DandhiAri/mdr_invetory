<?php include 'koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
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
									foreach($barang as $b){
								?>
									<option value="<?= $b->id_barang ?>"<?= $b->id_barang == $Detail_pinjam['id_barang'] ? "selected":""?>><?= $b->nama_barang ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Serial Code</label>
							<select class="form-control" name="serial_code" id="showSerialCode" required>
								<option value="">Pilih Nomor Seri</option>

							</select>
							<input type="text" name="id_detail_barang" id="id_detail_barang" hidden>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="qtty" class="form-label">Quantity</label>
							<input type="text" class="form-control" min="0" name="qtty" id="qtty" placeholder="Masukkan Kuantitas Quantity..." value="<?= $Detail_pinjam['qtty'] ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="lokasi" class="form-label">lokasi</label>
							<input type="text" class="form-control" name="lokasi" id="loksai" placeholder="Masukkan lokasi..." value="<?= $Detail_pinjam['lokasi'] ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="wkt_kembali" class="form-label">Waktu Kembali</label>
							<input type="datetime-local" class="form-control" name="wkt_kembali" id="wkt_kembali" type="text" class="form-control date" placeholder="Tanggal Kembali..." value="<?= $Detail_pinjam['wkt_kembali'] ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-control" name="status" id="status" placeholder="Pilih Status..." required>
								<?php
								$status_options = ['Requested','Finished','Rejected'];
								foreach ($status_options as $option) {
									$selected = ($Detail_pinjam['status'] == $option) ? 'selected' : '';
									echo "<option value='$option' $selected>$option</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan..." value="<?= $Detail_pinjam['keterangan'] ?>">
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('pinjam') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
