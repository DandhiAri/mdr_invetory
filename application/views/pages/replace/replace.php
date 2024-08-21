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
			<div class="col-md-5">
				<form action="<?= base_url('replace'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordRep" placeholder="Nama Barang, Serial Code, ID Pengajuan.....">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
        </div>
       
		<div class="ibox-body">
			<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Dropdown Detail</th>
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
						$id = json_encode(strtoupper($rp->id_replace));
						?>
						<tr>
							<td><?= ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?php echo $rp->id_replace ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Dropdown Detail
									</button>
									<script>
										function toggleDiv(id) {
											var div = document.getElementById('toggleDiv-'+ id);
											var buttonDrop = document.getElementById('dropdownMenuButton-'+ id);
											if (div.style.display === 'none' || div.style.display === '') {
												div.style.display = 'table-row';
												buttonDrop.classList.add("btn-success");
												buttonDrop.classList.remove("btn-primary");
											} else {
												div.style.display = 'none';
												buttonDrop.classList.remove("btn-success");
												buttonDrop.classList.add("btn-primary");
											}
										}
									</script>
								</div>
							</td>
							<td><?= $rp->id_replace ?></td>
							<!-- <td><?= $rp->id_barang ?></td>	 -->
							<td><?= $rp->nama ?></td>
							<td><?= $rp->tgl_replace ?></td>
							<td><?= $rp->status ?></td>
							<td><?= $rp->keterangan ?></td>
							<td>
								<a href="<?= base_url('Replace/edit_replace/') . $rp->id_replace ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-pencil"></i></a>
								<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Replace/hapus_replace/') . $rp->id_replace ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<tr style="display:none;" id="toggleDiv-<?php echo $rp->id_replace ?>" class=" nested-table-container" width="100%">
							<td colspan='20'>
								<p style="text-align:center;">
									<a href="<?= base_url('detail_replace/tambah_data_detail/'). $rp->id_replace  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Barang <?= $rp->id_replace ?> </a>
								</p>
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
											<th>Lokasi</th>
											<th>Status</th>
											<th>Keterangan</th>
											<th>Aksi</th>
										</tr>
										<?php 
										$no = 1;
										foreach($Detail_Replace as $d){
											if($d->id_replace === $rp->id_replace){
											?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $d->id_detail_replace ?></td>
												<td><?= $d->id_replace ?></td>
												<td><?= $d->tgl_replace ?></td>
												<td><?= $d->id_barang ?></td>
												<td><?= $d->qty_replace ?></td>
												<td><?= $d->serial_code ?></td>
												<td><?= $d->lokasi ?></td>
												<td><?= $d->status ?></td>
												<td><?= $d->keterangan ?></td>
												<td>
													<a href="<?= base_url('Detail_Replace/edit_detail/') . $d->id_detail_replace ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-pencil"></i></a>
													<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Detail_Replace/del_replace/') . $d->id_detail_replace.'/'.$d->id_replace ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
										<?php 
											}
										} 
										?>
									</thead>
								</table>
							</td>
						</tr>
					<?php } ?>
				</thead>
			</table>
			<?= $pagination ?>
		</div>
	</div>
</div>

