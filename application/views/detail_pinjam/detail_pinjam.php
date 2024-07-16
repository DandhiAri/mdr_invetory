<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Detail_pinjam/tambah_detail/'.$id.'') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Pinjam</a>
            </div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
						<th>Nama Barang</th>
						<th>Serial Code</th>
						<th>Item Description</th>
						<th>Quantity</th>
						<th>Lokasi</th>
						<th>Tanggal Kembali</th>
						<th>Jam Kembali</th>
						<th>Status</th>	
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($Detail_pinjam as $dp) {
                    ?>
                        <tr>
							<td><?php echo $no++ ?></td>
							
							<td><?php echo $dp->nama_barang ?></td>
							<td><?php echo $dp->serial_code ?></td>
							<td><?php echo $dp->item_description ?></td>
							<td><?php echo $dp->qtty ?></td>
							<td><?php echo $dp->lokasi ?></td>
							<td><?php echo $dp->tgl_kembali ?></td>
							<td><?php echo $dp->jam_kembali ?></td>
							<td><?php echo $dp->status ?></td>
							<td><?php echo $dp->keterangan ?></td>
							
                            <td>
                                <a href="<?= base_url('detail_pinjam/edit_data/') . $dp->id_detail_pinjam  ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('detail_pinjam/hapus/') . $dp->id_detail_pinjam.'/'.$dp->id_pinjam  ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="delete" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>

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