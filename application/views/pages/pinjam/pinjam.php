<div class="page-heading">
    <h1 class="page-title">Master Pinjam</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Pinjam/tambah_pinjam') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Pinjam</a>
            </div>
			<div class="col-md-5">
				<form action="<?= base_url('replace'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordRep" placeholder="Nama Barang, Serial Code, ID Pengajuan.....">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
			<?= $pagination ?>
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
						<th>Detail Pinjam</th>
                        <th>ID Pinjam</th>
                       	<th>Nama Tersangka</th>
                        <th>Waktu Pinjam</th>
                        <th>Status Pinjam</th>
                        <th>Action Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
				</thead>
				<tbody>
				<?php
                    $no = 1;
                    foreach ($Pinjam as $P) {
						$timestamp = strtotime($P->wkt_pinjam);
						$formatted_datetime = strftime('%d %B %Y %H:%M:%S',$timestamp);
						$id = json_encode(strtoupper($P->id_pinjam));
                    ?>
                        <tr>
                            <td><?= ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?= $P->id_pinjam ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <td><?= $P->id_pinjam ?></td>
							<td width="20%">
								<ul style="text-align:left; list-style:none; margin:0 0 0 0; padding:0;">
									<li><b>Nama PIC : </b><?= $P->nama_peminjam ?></li>
									<li><b>Nama Penerima : </b> <?= $P->nama_penerima ?></li>
									<li><b>Nama Pemberi :</b> <?= $P->nama_pemberi ?></li>
								</ul>
							</td>
                            <td><?= $formatted_datetime ?></td> 
							<td><p class='<?= $P->status ?>'><?= $P->status ?></p></td>
							<td>
								<a href="<?= base_url('Pinjam/accept/') . $P->id_pinjam ?>" title="Finished/Menerima replace semua barang" class="btn btn-success"><i class="fa fa-check"></i></a>
								<a href="<?= base_url('Pinjam/reject/') . $P->id_pinjam ?>" title="Rejected/Menolak replace semua barang" class="btn btn-danger"><i class="fa fa-remove"></i></a>
							</td>                 
							<td><?= $P->keterangan ?></td>
                            <td>
                                <a href="<?= base_url('pinjam/edit_data/') . $P->id_pinjam ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('pinjam/hapus_data/') . $P->id_pinjam ?>" class="btn btn-danger" onclick="confirm('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                            </td>
                        </tr>
						<tr style="display:none;" id="toggleDiv-<?= $P->id_pinjam ?>" class=" nested-table-container" width="100%">
							<td colspan='15'>
								<p style="text-align:center;">
									<a href="<?= base_url('detail_pinjam/tambah_detail/') . $P->id_pinjam  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Pinjam <?= $P->id_pinjam ?> </a>
								</p>
								<h5 style="text-align:center;">
									Detail pinjam <b><?= $P->id_pinjam ?></b> Table 
								</h5>
								<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Detail Barang</th>
											<th>Quantity</th>
											<th>Lokasi</th>
											<th>Keterangan</th>
											<th>Waktu Kembali</th>
											<th>Made By</th>
											<th>Status</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$hasData = false;
										foreach ($Detail_pinjam as $dp) {
											if($dp->id_pinjam === $P->id_pinjam){
												$hasData = true;
												$timestamp = strtotime($dp->wkt_kembali);
												$formatted_datetime = strftime('%d %B %Y %H:%M:%S',$timestamp);
										?>
											<tr>
												<td><?= $no++ ?></td>
												<td width="20%">
													<ul style="text-align:left; list-style:none; margin:0 0 0 0; padding:0;">
														<li><b>ID Barang : </b><?= $dp->id_barang ?></li>
														<li><b>ID Detail Barang : </b> <?= $dp->id_detail_barang ?></li>
														<li><b>SN : </b><?= !empty($dp->serial_code)  ? $dp->serial_code : "<i>NULL</i>" ?></li>
													</ul>
												</td>
												<td style="text-align:right;"><?= $dp->qtty ?></td>
												<td><?= $dp->lokasi ?></td>
												<td><?= $dp->keterangan ?></td>
												<td><?= $formatted_datetime ?></td>
												<td style="white-space:nowrap; font-size:13px;">
													<ul style="list-style:none; margin:0; padding:0;">
														<li>Created : <b><?= !empty($dp->user_create)  ? $dp->user_create : "<i>NULL</i>" ?></b></li>
														<li>Updated : <b><?= !empty($dp->user_update)  ? $dp->user_update : "<i>NULL</i>" ?></b></li>
													</ul>
												</td>
												<td><p class="<?= $dp->status ?>"><?= $dp->status ?></p></td>
												<td>
													<a href="<?= base_url('detail_pinjam/edit_data/') . $dp->id_detail_pinjam  ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
													<a href="<?= base_url('detail_pinjam/hapus/') . $dp->id_detail_pinjam.'/'.$dp->id_pinjam  ?>" class="btn btn-danger" onclick="confirm('Apakah anda yakin ingin menghapus?')" id="delete" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
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
													<hr>
												</div>
											</td>
										<?php
										}
										?>
									</tbody>
								</table>
							</td>
						</tr>
                <?php } ?>
				</tbody>
            </table>
			<?= $pagination ?>
        </div>
    </div>
</div>
