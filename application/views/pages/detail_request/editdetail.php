<?php include 'Koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Detail Request
            </div>
        </div>
        <div class="ibox-body">
            <form action="<?= base_url('Detail_Request/proses_ubah') ?>" method="POST">
            <div class="row">
				<div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_request" class="form-label">ID Request</label>
                            <input type="hidden" class="form-control" name="id_detail_request" id="id_detail_request" placeholder="ID Request..." value="<?= $Detail_Request['id_detail_request'] ?>" readonly>
                            <input type="text" class="form-control" name="id_request" id="id_request" placeholder="ID Request..." value="<?= $Detail_Request['id_request'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" min="1" value="<?= $Detail_Request['lokasi'] ?>">
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="mb-3">
                            <label  class="form-label">ID Barang</label>
                        <div class="input-group">
                            <select class="form-control" name="id_barang" id="getIdBarang" required>
                                <option value="" >Pilih Barang</option>
                                <?php 
								//foreach ($barang as $data) { 
								$itembarang = mysqli_query($koneksi,"select * from barang");
								while($b = mysqli_fetch_array($itembarang)){
								?>
                                    <option value="<?= $b['id_barang'] ?>"<?= $b['id_barang'] == $Detail_Request['id_barang'] ? "selected":""?>><?= $b['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
					<!--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah_request" class="form-label">Jumlah Request</label>
                            <input type="number" class="form-control" name="jumlah_request" id="jumlah_request" min="1" value="<?= $Detail_Request['jumlah_request'] ?>">
                        </div>
                    </div>-->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." value="<?= $Detail_Request['keterangan'] ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="serial_code" class="form-label">Serial Number</label>
                            <select class="form-control" name="serial_code" id="serial_code">
                                <option value="">Pilih Nomor Seri</option>
								<?php foreach ($detail_barang as $data) { ?>
                                    <!--<option value="<?= $data['serial_code'] ?>"<?= $data['serial_code'] == $Detail_Request['id_barang'] ? "selected":""?>><?= $data['serial_code'] ?></option>-->
									<option value="<?= $data['serial_code'] ?>" <?= $data['serial_code'] == $Detail_Request['serial_code'] ? "selected" : "" ?>>
									<?= $data['serial_code'] ?>
								</option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" value="<?= $Detail_Request['jumlah'] ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select class="form-control" name="status" id="status" placeholder="Pilih Status...">
							<?php
							$status_options = ['Requested', 'Finished', 'Rejected'];
							foreach ($status_options as $option) {
								$selected = ($Detail_Request['status'] == $option) ? 'selected' : '';
								echo "<option value='$option' $selected>$option</option>";
							}
							?>
						</select>
					</div>
				</div>
                        <!-- <div class="row"> -->
                            <div class="row float-right">
                                <div class="col-md-12">
                                    <button type="submit" formaction="<?= base_url('Detail_Request/proses_ubah') ?>" class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>

