<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form tambah pinjam
            </div>
        </div>
        <form action="<?= base_url('Pinjam/proses_ubah') ?>" method="POST">
            <div class="ibox-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" name="nama_peminjam" id="nama_peminjam" placeholder="Masukkan Nama Peminjam..." value="<?= $Pinjam['nama_peminjam'] ?>">
                            <input type="hidden" name="id_pinjam" id="nama_pinjam" value="<?= $Pinjam['id_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Masukkan Nama Penerima..." value="<?= $Pinjam['nama_penerima'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_pemberi" class="form-label">Nama Pemberi</label>
                            <input type="text" class="form-control" name="nama_pemberi" id="nama_pemberi" placeholder="Masukkan Nama Pemberi..." value="<?= $Pinjam['nama_pemberi'] ?>">
                        </div>
                    </div>
                    <!--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <select class="form-control" name="nama_barang" id="nama_barang">
                                <option value="">Pilih Barang</option>
                                <?php foreach ($barang as $data) { ?>
                                    <option value="<?= $data['nama_barang'] ?>"><?= $data['nama_barang'] ?></option>
                                <?php } ?>
                                <!-- tambahkan opsi barang lainnya sesuai kebutuhan 
                            </select>
                        </div>
                    </div>-->

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_pinjam" class="form-label">Tgl Pinjam</label>
                            <input type="date" class="form-control" name="tgl_pinjam" id="tgl_pinjam" placeholder="Masukkan Tgl Pinjam..." value="<?= $Pinjam['tgl_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jam_pinjam" class="form-label">Jam Pinjam</label>
                            <input type="time" class="form-control" name="jam_pinjam" id="jam_pinjam" placeholder="Masukkan Jam Pinjam..." value="<?= $Pinjam['jam_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan..." value="<?= $Pinjam['keterangan'] ?>">
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="row float-right">
    <div class="col-md-12">
        <a href="<?= base_url('Pinjam') ?>" class="btn btn-danger" id="deletepinjam" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
        <button type="submit" formaction="<?= base_url('Pinjam/proses_ubah') ?>" class="btn btn-success" id="simpanpinjam" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
    </div>
</div>
</form>
</div>
</div>div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form tambah pinjam
            </div>
        </div>
        <form action="<?= base_url('Pinjam/proses_ubah') ?>" method="POST">
            <div class="ibox-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_pinjam" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" name="nama_pinjam" id="nama_pinjam" placeholder="Masukkan Nama Peminjam..." value="<?= $Pinjam['nama_peminjam'] ?>">
                            <input type="hidden" name="id_pinjam" id="id_pinjam" value="<?= $Pinjam['id_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Masukkan Nama Penerima..." value="<?= $Pinjam['nama_penerima'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_pemberi" class="form-label">Nama Pemberi</label>
                            <input type="text" class="form-control" name="nama_pemberi" id="nama_pemberi" placeholder="Masukkan Nama Pemberi..." value="<?= $Pinjam['nama_pemberi'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_pinjam" class="form-label">Tgl Pinjam</label>
                            <input type="date" class="form-control" name="tgl_pinjam" id="tgl_pinjam" placeholder="Masukkan Tgl Pinjam..." value="<?= $Pinjam['tgl_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_kembali" class="form-label">Tgl Kembali</label>
                            <input type="date" class="form-control" name="tgl_kembali" id="tgl_kembali" type="text" class="form-control date" placeholder="Tanggal Kembali..." value="<?= $Pinjam['tgl_kembali'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jam_pinjam" class="form-label">Jam Pinjam</label>
                            <input type="time" class="form-control" name="jam_pinjam" id="jam_pinjam" placeholder="Masukkan Jam Pinjam..." value="<?= $Pinjam['jam_pinjam'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jam_kembali" class="form-label">Jam Kembali</label>
                            <input type="time" class="form-control" name="jam_kembali" id="jam_kembali" placeholder="Masukkan Jam Kembali..." value="<?= $Pinjam['jam_kembali'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan..." value="<?= $Pinjam['keterangan'] ?>">
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="row float-right">
    <div class="col-md-12">
        <a href="<?= base_url('Pinjam') ?>" class="btn btn-danger" id="deletepinjam" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
        <button type="submit" formaction="<?= base_url('Pinjam/proses_ubah') ?>" class="btn btn-success" id="simpanpinjam" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
    </div>
</div>
</form>
</div>
</div>