<div class="page-heading">
    <h1 class="page-title">Request</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('request/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah </a>
            </div>
        </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Request</th>
                    <th>PIC</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
					<th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach($Request as $r){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $r->id_request ?></td>
                        <td><?php echo $r->nama?></td>
                        <td><?php echo $r->tgl_request ?></td>
                        <!--<td><?php echo $r->barang_request ?>
                        <td><?php echo $r->jumlah ?></td></td>-->
                        <td><?php echo $r->keterangan ?></td>
						<td><?php echo $r->status ?></td>
                        <td>
						
                        <a onclick=return href="<?= base_url('detail_request/init/'). $r->id_request ?>" class="btn btn-warning" title="Detail"><i class="fa fa-edit"></i></a>
                        <a onclick=return href="<?= base_url('request/edit/') . $r->id_request ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('request/hapus_data/') . $r->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                </td>
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>
</div>