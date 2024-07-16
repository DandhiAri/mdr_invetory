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
            <form action="<?= base_url('Detail_Replace/proses_edit_detail')?>" method="POST">
            <div class="row">
                <!--<div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_replace" class="form-label">Nama Barang Replace</label>
                        <input type="text" class="form-control" name="nama_replace" id="nama" placeholder="Masukkan Nama..."
						value="<?= $Detail_Replace['nama_replace'] ?>">
                      
                    </div>
                </div>-->
				  <input type="hidden" name="id_detail_replace" id="id_detail_replace"
						value="<?= $Detail_Replace['id_detail_replace'] ?>">
						
				  <input type="hidden" name="id_replace" id="id_detail_replace"
						value="<?= $Detail_Replace['id_replace'] ?>">
						
						<div class="col-md-6">
                        <div class="mb-3">
                            <label  class="form-label">ID Barang</label>
                        <div class="input-group">
                            <select class="form-control" name="id_barang" id="getIdBarang" required>
                                <option value="" selected="selected" disabled="disabled">Pilih Barang</option>
                                <?php 
							//foreach ($barang as $data) { 
							$itembarang = mysqli_query($koneksi,"select * from barang");
							while($b = mysqli_fetch_array($itembarang)){
								?>
                                    <option value="<?= $b['id_barang'] ?>"<?= $b['id_barang'] == $Detail_Replace['id_barang'] ? "selected":""?>><?= $b['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
					<div class="col-md-6">
					<div class="mb-3">
						<label for="serial_code" class="form-label">Nomor Seri</label>
						<select class="form-control" name="serial_code" id="showSerialCode">
							<option value="" selected="selected" disabled="disabled">Pilih Nomor Seri</option>
							<?php foreach ($detail_barang as $data) { ?>
								<option value="<?= $data['serial_code'] ?>" <?= $data['serial_code'] == $Detail_Replace['serial_code'] ? "selected" : "" ?>>
									<?= $data['serial_code'] ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
                    <div class="mb-3">
                        <label for="qty_replace" class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="qty_replace" id="qty_replace" placeholder="Masukkan Jumlah..."value="<?= $Detail_Replace['qty_replace'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tgl_replace" class="form-label">Tanggal Replace</label>
                        <input type="date" class="form-control" name="tgl_replace" id="tgl_replace"value="<?= $Detail_Replace['tgl_replace'] ?>">
                    </div>
                    </div>
	
				<div class="col-md-6">
					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select class="form-control" name="status" id="status" placeholder="Pilih Status...">
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
                        <input type="text" class="form-control" name="lokasi" id="keterangan" min="1"value="<?= $Detail_Replace['lokasi'] ?>">
                    
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
                </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                            </div>
                            </div>
</form>
            </div>
        </div>
    </div>

</div>
