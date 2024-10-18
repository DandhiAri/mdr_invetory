<div class="page-heading">
    <h1 class="page-title">Master Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Barang</a>
			</div>
			<div class="col-md-5">
				<form action="<?= base_url('barang'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keyword" placeholder="Nama Barang, Serial Code, ID Pengajuan.....">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
			<?= $pagination ?>
        </div>
		<?php
		if($keyword){
		?>
			<p style="padding:7px 0 0 1.2em;">Keyword yang sedang dicari : <b><?= $keyword ?></b></p>
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
						<th>Detail Barang</th>
						<th>ID barang</th>
						<th>Nama Barang</th>
						<th>Jenis</th>
						<th>Stok</th>
						<th>Satuan</th>
						<th>Aksi</th>
					</tr>
					<?php 
					if(!$Barang==null){
						foreach($Barang as $b){
							$id = json_encode(strtoupper($b->id_barang));
					?>
						<tr>
							<td><?= ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?php echo $b->id_barang ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
							<td><?= $b->id_barang ?></td>
							<td><b><?= $b->nama_barang ?></b></td>
							<td><?= $b->nama_jenis ?></td>
							<td style="text-align:right;"><?= $b->detail_count; ?></td>
							<td><?= $b->nama_satuan ?></td>

							<td>
								<a onclick=return href="<?= base_url('barang/edit/') . $b->id_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
								<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/hapus_data/') . $b->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
							</td>
						</tr>
						<tr style="display:none;" id="toggleDiv-<?= $b->id_barang ?>" class=" nested-table-container" width="100%">
							<td colspan='20'>
								<p style="text-align:center;">
									<a href="<?= base_url('detail_barang/tambah/'). $b->id_barang  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Barang <?= $b->id_barang ?> </a>
								</p>
								<h5 style="text-align:center;">
									Detail Barang <b><?= $b->id_barang ?></b> Table 
								</h5>
								<table style="background-color:#DCDCDC;" class="table table-bordered">
									<thead>
										<tr>
											<th>No</th>
											<th>ID Detail Barang</th>
											<th>ID Pengajuan</th>
											<th>Serial Code</th>
											<th>Jumlah</th>
											<th>Lokasi</th>
											<th>Keterangan</th>
											<th>Created At</th>
											<?php if($b->nama_satuan == "Unit"){ ?>
											<th>Transaksi</th>
											<th>Status</th>
											<?php } ?>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$nom = 1;
										$hasData = false;
										foreach($DetailBarang as $detail){
											if($detail->id_barang === $b->id_barang){
											$hasData = true;
										?>
											<tr>
												<td><?= $nom++ ?></td>
												<td><b><?= $detail->id_detail_barang ?></b></td>
												<td><?= $detail->id_pengajuan ?></td>
												<td><b><?= $detail->serial_code?></b></td>
												<td style="text-align:right;"><?= $detail->qtty?></td>
												<td><b><?= $detail->lokasi?></b></td>
												<td><?= $detail->keterangan?></td>
												<td><?= $detail->created_at ?></td>
												<?php if($b->nama_satuan == "Unit"){ ?>
												<td >
													<ul style="text-align:left; list-style:none; margin:0; padding:0; white-space:nowrap; font-size:13px;">
														<li>Nama PIC : <b><?= !empty($detail->PIC)  ? $detail->PIC : "<i>NULL</i>" ?></b></li>
														<li>ID Transaksi : <b><?= !empty($detail->id_transaksi)  ? $detail->id_transaksi : "<i>NULL</i>" ?></b></li>
													</ul>
												</td>
												<td><p class='<?= $detail->status ?>'><?= $detail->status ?></p></td>
												<?php } ?>
												<td>
													<a onclick=return href="<?= base_url('detail_barang/edit/') . $detail->id_detail_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
													<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_barang/hapus_data/') . $detail->id_detail_barang.'/'.$detail->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
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
									</tbody>
								</table>
							</td>
						</tr>
					<?php 
						}
					} elseif ($keyword == ""){
					?>
						<td colspan="20">
							<div class="null-result-container">
								<p class="null-result">Tidak Ada Data untuk Ditampilkan :(</p>
							</div>
						</td>
					<?php } else { ?>
						<td colspan="20">
							<div class="null-result-container">
								<p class="null-result">Keyword <b>"<?= $keyword ?>"</b> yang dicari tidak ada</p>
								<form action="<?= base_url('barang'); ?>" style="display:flex;" method="post">
									<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1">Kembali Semula</button>
								</form>
							</div>
						</td>
					<?php } ?>
				</thead>
			</table>
			<div style="display:flex; justify-content:space-between;">
				<p>
					Show <?= count($Barang) ?> of <?= $total_rows ?> Barang
				</p>
				<?= $pagination ?>
			</div>
		</div>
	</div>
</div>
