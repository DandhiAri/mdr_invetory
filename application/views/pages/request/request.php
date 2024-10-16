<div class="page-heading">
    <h1 class="page-title">Request</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('request/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah </a>
            </div>
			<div class="col-md-5">
				<form action="<?= base_url('request'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordReq" placeholder="Nama PIC, Serial Code, ID Pengajuan.....">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
			<?= $pagination ?>
        </div>		
		<?php
		if($keywordReq){
		?>
			<p style="padding:7px 0 0 1.2em;">Keyword yang sedang dicari : <b><?= $keywordReq ?></b></p>
		<?php
		}
		?>
		<div class="ibox-body">
			<?php if ($this->session->flashdata('success')): ?>
				<div class="warn succ">
					<div class="msg" onclick="warnError()">
						<?= $this->session->flashdata('success'); ?>
					</div>
				</div>
			<?php elseif ($this->session->flashdata('failed')):?>
				<div class="warn err">
					<div class="msg" onclick="warnError()">
						<?= $this->session->flashdata('failed'); ?>
					</div>
				</div>
			<?php endif;?>
			<table style="align-items:center; text-align:center;" class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Detail Request</th>
						<th>ID Request</th>
						<th>PIC</th>
						<th>Tanggal Request</th>
						<th>Status Request</th>
						<th>Status Action</th>
						<th>Keterangan</th>
						<th>Action</th>
					</tr>
					<?php 
					$no = 1;
					foreach($Request as $r){
						$formatted_date = date('d F Y', strtotime($r->tgl_request));
						$id = json_encode(strtoupper($r->id_request));
						?>
						<tr>
							<td><?= ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?= $r->id_request ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Detail Request
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
							<td><?= $r->id_request ?></td>
							<td><b><?= $r->nama?></b></td>
							<td><?= $formatted_date ?></td>
							<td><p class="<?= $r->status ?>"><?= $r->status ?></p></td>
							<td>
								<div class="row" style="justify-content:center;">
									<a href="<?= base_url('request/accept/') . $r->id_request ?>" class="btn btn-success" style="margin-right:5px;" title="Finished/Menerima request semua barang"><i class="fa fa-check"></i></a>
									<a href="<?= base_url('request/reject/') . $r->id_request ?>" class="btn btn-danger" id="deleterequest" title="Rejected/Menolak request semua barang" style="cursor: pointer;"><i class="fa fa-remove"></i></a>
								</div>
							</td>
							<td><?= $r->keterangan ?></td>
							<td>
								<div class="row" style="padding-bottom:10px; justify-content:center;">
									<a href="<?= base_url('request/edit/') . $r->id_request ?>" class="btn btn-warning" style="margin-right:5px;" title="Edit"><i class="ti ti-pencil"></i></a>
									<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('request/hapus_data/') . $r->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></a>
								</div>
							</td>
					</tr>
					<tr style="display:none;" id="toggleDiv-<?= $r->id_request ?>" class=" nested-table-container" width="100%">
						<td colspan='20'>
							<p style="text-align:center;">
								<a href="<?= base_url('detail_request/tambah/'). $r->id_request  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Request <?= $r->id_request ?> </a>
							</p>
							<h5 style="text-align:center;">
								Detail Request <b><?= $r->id_request ?></b> Table 
							</h5>
							<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>No</th>
									<th>ID</th>
									<th>Detail Barang</th>
									<th>Quantity</th>
									<th>Lokasi</th>
									<th>Keterangan</th>
									<th>Waktu Update</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
									<?php 
									$no = 1;
									$hasData = false;
									foreach($Detail_Request as $dr){
										if($dr->id_request === $r->id_request){
										$hasData = true;
									?>
										<tr>
											<td><?= $no++ ?></td>
											<td><b><?= $dr->id_detail_request ?></b></td>
											<td width="20%">
												<ul style="text-align:left; list-style:none; margin:0 0 0 0; padding:0; white-space: nowrap;">
													<li><b>ID Barang : </b><?= $dr->id_barang ?></li>
													<li><b>ID Detail Barang : </b> <?= $dr->id_detail_barang ?></li>
													<li><b>SN : </b><?= !empty($dr->serial_code)  ? $dr->serial_code : "<i>NULL</i>" ?></li>
												</ul>
											</td>
											<td style="text-align:right;"><?= $dr->qtty ?></td>
											<td ><b><?= $dr->lokasi ?></b></td>
											<td><?= $dr->keterangan?></td>
											<td><?= $dr->tgl_request_update ?></td>
											<td><p class="<?= $dr->status ?>"><?= $dr->status ?></p></td>
											<td>
												
												<a href="<?= base_url('detail_request/edit/') . $dr->id_detail_request ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
												<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_request/hapus_data/') . $dr->id_detail_request.'/'.$dr->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i>
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
			<div style="display:flex; justify-content:space-between;">
				<p>
					Show <?= count($Request) ?> of <?= $total_rows ?> Data Request
				</p>
				<?= $pagination ?>
			</div
		</div>
	</div>
</div>
