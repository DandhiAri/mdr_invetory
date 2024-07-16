<div class="page-heading">
    <h1 class="page-title">Detail Request</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('detail_request/tambah/'.$id.'') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah </a>
            </div>
        </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Detail Request</th>
					<th>ID Request</th>
                    <th>Keterangan</th>
                    <th>ID Barang</th>
                    <th>Serial Code</th>
					<th>Item Description</th>
                    <th>Lokasi</th>
					<th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach($Detail_Request as $dr){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $dr->id_detail_request ?></td>
						<td><?php echo $dr->id_request ?></td>
                        <td><?php echo $dr->keterangan?></td>
                        <td><?php echo $dr->id_barang ?></td>
                        <td><?php echo $dr->serial_code ?></td>
						<td><?php echo $dr->item_description ?></td>
						<td><?php echo $dr->lokasi ?></td>
                        <td><?php echo $dr->jumlah ?></td>
                        <td><?php echo $dr->status ?></td>
                        <td>
                        
                        <a onclick=return href="<?= base_url('detail_request/edit/') . $dr->id_detail_request ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_request/hapus_data/') . $dr->id_detail_request.'/'.$dr->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                </td>
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>
</div>