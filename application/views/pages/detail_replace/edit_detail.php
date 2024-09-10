<?php include 'Koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Data Detail Replace
            </div>
        </div>
        <div class="ibox-body">
            <form action="<?= base_url('Detail_Replace/proses_edit_detail/'.$id)?>" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">ID Replace</label>
							<input type="text" class="form-control" readonly name="id_replace" id="id_detail_replace" value="<?= $Detail_Replace['id_replace'] ?>">		
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label  class="form-label">ID Barang</label>
							<div class="input-group">
								<select class="form-control" name="id_barang" id="getIdBarang" required>
									<option value="" selected="selected" disabled="disabled">Pilih Barang</option>
									<?php 
									foreach ($Barang as $b) { 
									?>
										<option value="<?= $b->id_barang ?>"<?= $b->id_barang == $Detail_Replace['id_barang'] ? "selected":""?>>
											<?= $b->nama_barang ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="qtty" class="form-label">Quantity</label>
							<input type="number" class="form-control" name="qtty" id="qtty" placeholder="Masukkan Jumlah..."value="<?= $Detail_Replace['qtty'] ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="serial_code" class="form-label">Nomor Seri</label>
							<select class="form-control" name="serial_code" id="showSerialCode" required>
								<option value="" selected="selected" disabled="disabled">Pilih Nomor Seri</option>

							</select>
							<input type="text" name="id_detail_barang" id="id_detail_barang" hidden>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="mb-3">
							<label for="tgl_replace_update" class="form-label">Tanggal Replace</label>
							<input type="datetime-local" class="form-control" name="tgl_replace_update" id="tgl_replace_update" value="<?= $Detail_Replace['tgl_replace_update'] ?>" required>
						</div>
					</div>
		
					<div class="col-md-6">
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-control" name="status" id="status" placeholder="Pilih Status..." required>
								<?php
								$status_options = ['Requested', 'Finished', 'Rejected'];
								foreach ($status_options as $option) {
									$selected = ($Detail_Replace['status'] == $option) ? 'selected' : '';
									echo "<option value='$option' $selected>$option</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="lokasi" class="form-label">Lokasi</label>
							<input type="text" class="form-control" name="lokasi" id="keterangan" min="1"value="<?= $Detail_Replace['lokasi'] ?>" required>
						
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="keterangan" class="form-label">keterangan</label>
							<input type="text" class="form-control" name="keterangan" id="keterangan" min="1"value="<?= $Detail_Replace['keterangan'] ?>">
						</div>
					</div>
				</div>
				</div>
					<div class="row float-right">
						<div class="col-md-12">
							<a href="<?= base_url('replace') ?>" class="btn btn-danger" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
							<button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
