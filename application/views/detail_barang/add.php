<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="row justify-content-center">
<!-- <div class="page-content fade-in-up"> -->
<div class="col-md-8">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Detail Barang
            </div>
        </div>
        <div class="ibox-body">
            <form action="<?= base_url('Detail_barang/proses_tambah') ?>" method="POST">
                    <!--<div class="row form-group">
                    <label class="col-md-2 text-md-right" for="id_barang">ID Barang</label>
                    <div class="col-md-3">
                        <div class="input-group">
                            <select class="form-control" name="id_barang" id="id_barang">
                                <option value="" >Pilih Barang</option>
                                <?php foreach ($barang as $data) { ?>
                                    <option value="<?= $data['id_barang'] ?>"><?= $data['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>-->
				
					<div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_barang" class="form-label">ID Barang</label>
							<input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="id ..." value="<?= $id ?>" readonly>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_description" class="form-label">Item Description</label>
							<input type="text" class="form-control" name="item_description" id="item_description" placeholder="masukkan item description ...">
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
						</div>
					<div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." >
                        </div>
                        <!-- </div> -->
                        <div class="row">
                            <div class="row float-right">
                                <div class="col-md-12">
                                    <button type="submit" formaction="<?= base_url('Detail_barang/proses_tambah') ?>" class="btn btn-success" id="simpan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>