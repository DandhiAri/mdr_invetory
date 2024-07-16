<div class="page-heading">
    <h1 class="page-title">Master Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Barang</a>
            </div>
        </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    
                    <th>Nama Barang</th>
					<th>Jenis</th>
                    <th>Quantity</th>
                    <th>Satuan</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach($Barang as $b){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        
                        <td><?php echo $b->nama_barang ?></td>
						<td><?php echo $b->id_jenis ?></td>
                        <td><?php echo $b->stok ?></td>
                        <td><?php echo $b->id_satuan ?></td>
                        
                        <td>
                        <a onclick=return href="<?= base_url('detail_barang/init/') . $b->id_barang ?>" class="btn btn-warning" title="Detail"><i class="fa fa-edit"></i></a>
                        <a onclick=return href="<?= base_url('barang/edit/') . $b->id_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/hapus_data/') . $b->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                </td>
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>
</div>