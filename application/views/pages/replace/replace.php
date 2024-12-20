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
			<div class="col"></div>
			<div class="col-md-5">
				<form action="<?= base_url('replace'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordRep" placeholder="Ketik keyword disini . . . . . . . . . . . . . . . . . . .">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
			<?= $pagination ?>
        </div>
		<?php
		if($keywordRep){
		?>
			<p style="padding:7px 0 0 1.2em;">Keyword yang sedang dicari : <b><?= $keywordRep ?></b></p>
		<?php
		}
		?>
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
						<th>Detail Replace</th>
						<th>ID Replace</th>
						<th>PIC</th>
						<th>Tanggal Replace</th>
						<th>Status Replace</th>
						<th>Status Action</th>
						<th>Aksi</th>
					</tr>
					<?php 
					$no = 1;
					foreach($Replace as $rp){
						$formatted_date = date('d F Y', strtotime($rp->tgl_replace));
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
							<td><b><?= $rp->nama ?></b></td>
							<td><?= $formatted_date ?></td>
							<td> <p class="<?= $rp->status ?>"><?= $rp->status ?></p></td>
							<td>
								<a href="<?= base_url('Replace/accept/') . $rp->id_replace ?>" title="Finished/Menerima replace semua barang" class="btn btn-success"><i class="fa fa-check"></i></a>
								<a href="<?= base_url('Replace/reject/') . $rp->id_replace ?>" title="Rejected/Menolak replace semua barang" class="btn btn-danger"><i class="fa fa-remove"></i></a>
							</td>
							<td>
								<a href="<?= base_url('Replace/edit_replace/') . $rp->id_replace ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
								<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Replace/hapus_replace/') . $rp->id_replace ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<tr style="display:none;" id="toggleDiv-<?php echo $rp->id_replace ?>" class=" nested-table-container" width="100%">
							<td colspan='20'>
								<p style="text-align:center;">
									<a href="<?= base_url('detail_replace/tambah_data_detail/'). $rp->id_replace  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Data Detail Replace <?= $rp->id_replace ?> </a>
								</p>
								<h5 style="text-align:center;">
									Detail Replace <b><?= $rp->id_replace ?></b> Table 
								</h5>
								<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>ID</th>
											<th>Detail Barang</th>
											<th>Jumlah</th>
											<th>Tujuan</th>
											<th>Keterangan</th>
											<th>Waktu Update</th>
											<th>Made By</th>
											<th>Status</th>
											<th>Aksi</th>
										</tr>
										<?php 
										$no = 1;
										$hasData = false;
										foreach($Detail_Replace as $d){
											if($d->id_replace === $rp->id_replace){
											$hasData = true;
											?>
											<tr>
												<td><?= $no++ ?></td>
												<td><b><?= $d->id_detail_replace ?></b></td>
												<td width="20%">
													<ul style="text-align:left; list-style:none; margin:0 0 0 0; padding:0;">
														<li><b>ID Barang : </b><?= $d->id_barang ?></li>
														<li><b>ID Detail Barang : </b> <?= $d->id_detail_barang ?></li>
														<li><b>SN : </b><?= !empty($d->serial_code)  ? $d->serial_code : "<i>NULL</i>" ?></li>
													</ul>
												</td>
												<td style="text-align:right;"><?= $d->qtty ?></td>
												<td><?= $d->lokasi ?></td>
												<td><?= $d->keterangan ?></td>
												<td><?= $d->tgl_replace_update ?></td>
												<td style="white-space:nowrap; font-size:13px;">
													<ul style="list-style:none; margin:0; padding:0;">
														<li>Created : <b><?= !empty($d->user_create)  ? $d->user_create : "<i>NULL</i>" ?></b></li>
														<li>Updated : <b><?= !empty($d->user_update)  ? $d->user_update : "<i>NULL</i>" ?></b></li>
													</ul>
												</td>
												<td><p class="<?= $d->status ?>"><?= $d->status ?></p></td>
												<td>
													<a href="<?= base_url('Detail_Replace/edit_detail/') . $d->id_detail_replace ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
													<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Detail_Replace/del_replace/') . $d->id_detail_replace.'/'.$d->id_replace ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
										<?php 
											}
										}
										if (!$hasData) {
										?>
											<td colspan="20">
												<div class="null-result-container">
													<p class="null-result">Tidak Ada Data untuk Ditampilkan :(</p>
												</div>
											</td>
										<?php
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

