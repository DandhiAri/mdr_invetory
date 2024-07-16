<div class="page-heading">
    <h1 class="page-title">Data Satuan</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Satuan/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah satuan</a>
            </div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Satuan</th>
                        <th>Nama Satuan</th>
                        <!--<th>Nomer Seri</th>-->
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($Satuan as $S) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $S->id_satuan ?></td>
                            <td><?php echo $S->nama_satuan ?></td>
                            <!--<td><?php echo $S->nomer_seri ?></td>-->
                            <td>
                                <a href="<?= base_url('satuan/edit_data/' . $S->id_satuan) ?>" class="btn btn-warning" title="Edit satuan"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('satuan/hapus_data/' . $S->id_satuan) ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
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