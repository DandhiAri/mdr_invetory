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
                        <th>PIC</th>
                        <th>Nama Penerima</th>
                        <th>Nama Pemberi</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jam Pinjam</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
				</thead>
				<tbody>
				<?php
                    $no = 1;
                    foreach ($Pinjam as $P) {
						$id = json_encode(strtoupper($P->id_pinjam));
                    ?>
                        <tr>
                            <td><?php echo ++$page ?></td>
							<td>
								<div class="dropdown">
									<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?php echo $P->id_pinjam ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <td><?php echo $P->id_pinjam ?></td>
                            <td><?php echo $P->nama_peminjam ?></td>
                            <td><?php echo $P->nama_penerima ?></td>
                            <td><?php echo $P->nama_pemberi ?></td>
                            <td><?php echo $P->tgl_pinjam ?></td>
                            <td><?php echo $P->jam_pinjam ?></td>                            
							<td><?php echo $P->keterangan ?></td>
                            <td>
                                <a href="<?= base_url('pinjam/edit_data/') . $P->id_pinjam ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('pinjam/hapus_data/') . $P->id_pinjam ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                            </td>
                        </tr>
						<tr style="display:none;" id="toggleDiv-<?php echo $P->id_pinjam ?>" class=" nested-table-container" width="100%">
							<td colspan='15'>
								<p style="text-align:center;">
									<a href="<?= base_url('detail_pinjam/tambah_detail/') . $P->id_pinjam  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Barang <?= $P->id_pinjam ?> </a>
								</p>
								<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Barang</th>
											<th>Serial Code</th>
											<th>Quantity</th>
											<th>Lokasi</th>
											<th>Tanggal Kembali</th>
											<th>Jam Kembali</th>
											<th>Status</th>	
											<th>Keterangan</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($Detail_pinjam as $dp) {
										?>
											<tr>
												<td><?php echo $no++ ?></td>		
												<td><?php echo $dp->id_barang ?></td>
												<td><?php echo $dp->serial_code ?></td>
												<td><?php echo $dp->qtty ?></td>
												<td><?php echo $dp->lokasi ?></td>
												<td><?php echo $dp->tgl_kembali ?></td>
												<td><?php echo $dp->jam_kembali ?></td>
												<td><?php echo $dp->status ?></td>
												<td><?php echo $dp->keterangan ?></td>
												
												<td>
													<a href="<?= base_url('detail_pinjam/edit_data/') . $dp->id_detail_pinjam  ?>" class="btn btn-warning" title="Edit pinjam"><i class="ti ti-pencil"></i></a>
													<a href="<?= base_url('detail_pinjam/hapus/') . $dp->id_detail_pinjam.'/'.$dp->id_pinjam  ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="delete" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
												</td>
											</tr>
										<?php } ?>
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
