<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form tambah barang
            </div>
        </div>
        <form action="<?= base_url('Satuan/proses_tambah') ?>" method="POST">
            <div class="ibox-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_satuan" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" name="nama" id="nama_satuan" placeholder="Masukkan nama barang...">
                        </div>
                    </div>
                    <!--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomer_seri" class="form-label">Nomer Seri</label>
                            <input type="text" class="form-control" name="nomer" id="nomer_seri" min="1">
                        </div>
                    </div>-->
                </div>
            </div>
    </div>
    <div class="row float-right">
        <div class="col-md-12">
            <a href="<?= base_url('Satuan') ?>" class="btn btn-danger" id="deleteSatuan" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
            <button type="submit" formaction="<?= base_url('Satuan/proses_tambah') ?>" class="btn btn-success" id="simpansatuan" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
        </div>
    </div>
    </form>
</div>
</div>