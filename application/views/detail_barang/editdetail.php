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
                            <label for="item_description" class="form-label">Item Description</label>
							<input type="text" class="form-control" name="item_description" id="item_description" placeholder="masukkan item description ..." value="<?= $Detail_Barang['item_description'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="serial_code" class="form-label">Serial Code</label>
                            <input type="text" class="form-control" name="serial_code" id="serial_code" min="1" value="<?= $Detail_Barang['serial_code'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan lokasi..." value="<?= $Detail_Barang['lokasi'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qtty" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="qtty" id="qtty" min="1" value="<?= $Detail_Barang['qtty'] ?>">
                        </div>
						</div>
					<div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="qtty" placeholder="Masukkan keterangan..." value="<?= $Detail_Barang['keterangan'] ?>">
                        </div>
                        <!-- <div class="row"> -->
                            <div class="row float-right">
                                <div class="col-md-12">
                                    
                                    <button type="submit" formaction="<?= base_url('Detail_Barang/proses_ubah/'.$Detail_Barang['id_detail_barang']) ?>" class="btn btn-success" id="btn-save-mtact" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>