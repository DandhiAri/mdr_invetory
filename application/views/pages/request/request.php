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
        </div>
		<?= $keywordReq ?>
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
						<th>Detail Request</th>
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
						$id = json_encode(strtoupper($r->id_request));
						?>
						<tr>
							<td><?php echo ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?php echo $r->id_request ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
							<td><?php echo $r->id_request ?></td>
							<td><?php echo $r->nama?></td>
							<td><?php echo $r->tgl_request ?></td>
							<td><?php echo $r->keterangan ?></td>
							<td><?php echo $r->status ?></td>
							<td>
								<a onclick=return href="<?= base_url('request/edit/') . $r->id_request ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
								<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('request/hapus_data/') . $r->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
							</td>
					</tr>
					<tr style="display:none;" id="toggleDiv-<?php echo $r->id_request ?>" class=" nested-table-container" width="100%">
						<td colspan='8'>
							<p style="text-align:center;">
								<a href="<?= base_url('detail_request/tambah/'). $r->id_request  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Request <?= $r->id_request ?> </a>
							</p>
							<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>No</th>
									<th>ID Detail Request</th>
									<th>ID Request</th>
									<th>ID Barang</th>
									<th>ID Detail Barang</th>
									<th>Serial Code</th>
									<th>Lokasi</th>
									<th>Jumlah</th>
									<th>Keterangan</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
									<?php 
									$no = 1;
									foreach($Detail_Request as $dr){
										if($dr->id_request === $r->id_request){
										?>
										<tr>
										<td><?= $no++ ?></td>
										<td><?= $dr->id_detail_request ?></td>
										<td><?= $dr->id_request ?></td>
										<td><?= $dr->id_barang ?></td>
										<td><?= $dr->id_detail_barang ?></td>
										<td><?= $dr->serial_code ?></td>
										<td><?= $dr->lokasi ?></td>
										<td><?= $dr->jumlah ?></td>
										<td><?= $dr->keterangan?></td>
										<td><?= $dr->status ?></td>
											<td>
												<a onclick=return href="<?= base_url('detail_request/edit/') . $dr->id_detail_request ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
												<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_request/hapus_data/') . $dr->id_detail_request.'/'.$dr->id_request ?>"class="btn btn-danger" id="deleterequest" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i>
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
