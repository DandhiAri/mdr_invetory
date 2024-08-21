<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
			<a href="<?= base_url('replace') ?>" class="btn btn-danger" id="barang" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
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
                        <td><?= $no++ ?></td>
                        <td><?= $d->id_detail_replace ?></td>
						<td><?= $d->id_replace ?></td>
                        <td><?= $d->tgl_replace ?></td>
                        <td><?= $d->id_barang ?></td>
                        <td><?= $d->qty_replace ?></td>
                        <td><?= $d->serial_code ?></td>
						<td><?= $d->item_description ?></td>
						<td><?= $d->lokasi ?></td>
                        <td><?= $d->status ?></td>
                        <td><?= $d->keterangan ?></td>
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

