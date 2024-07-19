<div class="page-heading">
    <h1 class="page-title">Master Pinjam</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Pinjam/tambah_pinjam') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Pinjam</a>
            </div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pinjam</th>
                        <th>PIC</th>
                        <th>Nama Penerima</th>
                        <th>Nama Pemberi</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jam Pinjam</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($Pinjam as $P) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $P->id_pinjam ?></td>
                            <td><?php echo $P->nama_peminjam ?></td>
                            <td><?php echo $P->nama_penerima ?></td>
                            <td><?php echo $P->nama_pemberi ?></td>
                           <!-- <td><?php echo $P->nama_barang ?></td> -->
                            <td><?php echo $P->tgl_pinjam ?></td>
                            <td><?php echo $P->jam_pinjam ?></td>                            <td><?php echo $P->keterangan ?></td>
                            <td>
                                <a href="<?= base_url('detail_pinjam/init/') . $P->id_pinjam ?>" class="btn btn-warning" title="Detail Pinjam"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('pinjam/edit_data/') . $P->id_pinjam ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('/pinjam/hapus_data/') . $P->id_pinjam ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                            </td>
                        </tr>
                        </tr>
                </thead>
                <tbody>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>