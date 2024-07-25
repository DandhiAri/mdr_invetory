<?php include 'Koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Data Replace
            </div>
        </div>
        <div class="ibox-body">
            <form action="<?= base_url('Replace/proses_edit_replace')?>" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">PIC</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama..."value="<?= $Replace['nama'] ?>">
                        <input type="hidden" name="id_replace" id="id_replace" value="<?= $Replace['id_replace'] ?>">
                    </div>
                </div>
                   <!-- <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah..."value="<?= $Replace['jumlah'] ?>">
                    </div>
                </div>
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
                                    <option value="<?= $b['id_barang'] ?>"<?= $b['id_barang'] == $Replace['id_barang'] ? "selected":""?>><?= $b['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tgl_replace" class="form-label">Tanggal Replace</label>
                        <input type="date" class="form-control" name="tgl_replace" id="tgl_replace"value="<?= $Replace['tgl_replace'] ?>">
                    </div>
					</div>
				<div class="col-md-6">
					<div class="mb-3">
					<label for="serial_code" class="form-label">Nomor Seri</label>
					<select class="form-control" name="serial_code" id="showSerialCode">
					<option value="" selected="selected" disabled="disabled">Pilih Nomor Seri</option>
					<?php foreach ($detail_barang as $b) { ?>
						<option value="<?= $b['serial_code'] ?>" <?= $b['serial_code'] == $Replace['serial_code'] ? "selected" : "" ?>>
							<?= $b['serial_code'] ?>
						</option>
					<?php } ?>
							</select>
						</div>
					</div>

                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="qty" id="qty" placeholder="Masukkan Kuantitas Barang..." value="<?= $Replace['qty'] ?>">
                    </div>
                    </div>-->
					 <div class="col-md-6">
					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select class="form-control" name="status" id="status" placeholder="Pilih Status...">
							<?php
							$status_options = ['Requested', 'Finished', 'Rejected'];
							foreach ($status_options as $option) {
								$selected = ($Replace['status'] == $option) ? 'selected' : '';
								echo "<option value='$option' $selected>$option</option>";
							}
							?>
						</select>
					</div>
				</div>
		   
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" min="1"value="<?= $Replace['keterangan'] ?>">
                    </div>
                    </div>
                </div>
                    </div>
                </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <a href="<?= base_url('Replace') ?>" class="btn btn-danger" id="deletereplace" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
                                <button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                            </div>
                            </div>
</form>
            </div>
        </div>
    </div>

</div>
</div>