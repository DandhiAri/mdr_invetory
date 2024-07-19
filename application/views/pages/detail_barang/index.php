<div class="page-heading">
    <h1 class="page-title">Detail Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
				<a href="<?= base_url('barang')?>" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Kembali </a>
                <a href="<?= base_url('detail_barang/tambah/'). $id  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah </a>
            </div>
        </div>
		<div class="ibox-body">
			<?php if ($this->session->flashdata('success')): ?>
				<div class="warn succ">
					<div class="msg" onclick="warnError()">
						<?php echo $this->session->flashdata('success'); ?>
					</div>
				</div>
			<?php elseif ($this->session->flashdata('failed')):?>
				<div class="warn err">
					<div class="msg" onclick="warnError()">
						<?php echo $this->session->flashdata('failed'); ?>
					</div>
				</div>
			<?php endif;?>
			<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>ID Detail Barang</th>
						<th>ID Barang</th>
						<th>Nama Barang</th>
						<th>Item Description</th>
						<th>Serial Code</th>
						<th>Lokasi</th>
						<th>Quantity</th>
						<th>Keterangan</th>
						<th>Aksi</th>
					</tr>
					<?php
						$no = 1;
						foreach($Detail_Barang as $dbr){
					?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $dbr->id_detail_barang ?></td>
							<td><?php echo $dbr->id_barang?></td>
							<td><?php echo $dbr->nama_barang?></td>
							<td><?php echo $dbr->item_description?></td>
							<td><?php echo $dbr->serial_code?></td>
							<td><?php echo $dbr->lokasi?></td>
							<td><?php echo $dbr->qtty?></td>
							<td><?php echo $dbr->keterangan?></td>
							<td>
							
							<a onclick=return href="<?= base_url('detail_barang/edit/') . $dbr->id_detail_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
							<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_barang/hapus_data/') . $dbr->id_detail_barang.'/'.$dbr->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
					</td>
					</tr>
					<?php } ?>
				</thead>
			</table>
		</div>
	</div>
</div>
