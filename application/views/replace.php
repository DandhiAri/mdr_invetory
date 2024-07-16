<!DOCTYPE html>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
           <a href="<?= base_url('replace/tambah_data_replace') ?>" class="btn btn-sm btn-primary btn-icon-split">
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
                    <th>ID Replace</th>
                    <th>PIC</th>
                    <th>Tanggal Replace</th>
					<th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach($Replace as $rp){
				//foreach($Replace as $r){
					//$status_class = $r->status === 'requested' ? 'table-requested-row' : '';
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $rp->id_replace ?></td>
						<!--<td><?php echo $rp->id_barang ?></td>-->
                        <td><?php echo $rp->nama ?></td>
                        <td><?php echo $rp->tgl_replace ?></td>
						<td><?php echo $rp->status ?></td>
                        <td><?php echo $rp->keterangan ?></td>
                        <td>
                        <a href="<?= base_url('Detail_Replace/init/') . $rp->id_replace ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('Replace/edit_replace/') . $rp->id_replace ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-pencil"></i></a>
                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Replace/hapus_replace/') . $rp->id_replace ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                </td>
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>
</div>

