<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
           <a href="<?= base_url('Detail_Replace/tambah_data_detail/'.$id.'') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Data Replace
                    </span>
					</a>
        </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Detail Replace</th>
					<th>ID Replace</th>
                    <th>Tanggal Replace</th>
                    <th>ID Barang</th>
                    <th>Quantity</th>
                    <th>No Seri</th>
					<th>Item_Description</th>
					<th>Lokasi</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach($Detail_Replace as $d){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $d->id_detail_replace ?></td>
						<td><?php echo $d->id_replace ?></td>
                        <td><?php echo $d->tgl_replace ?></td>
                        <td><?php echo $d->id_barang ?></td>
                        <td><?php echo $d->qty_replace ?></td>
                        <td><?php echo $d->serial_code ?></td>
						<td><?php echo $d->item_description ?></td>
						<td><?php echo $d->lokasi ?></td>
                        <td><?php echo $d->status ?></td>
                        <td><?php echo $d->keterangan ?></td>
                        <td>
						
                        <a href="<?= base_url('Detail_Replace/edit_detail/') . $d->id_detail_replace ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-pencil"></i></a>
                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Detail_Replace/del_replace/') . $d->id_detail_replace.'/'.$d->id_replace ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                </td>
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>
</div>

