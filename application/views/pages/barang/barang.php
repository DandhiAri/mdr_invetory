<div class="page-heading">
    <h1 class="page-title">Master Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Barang</a>
            </div>
        </div>
		<div class="ibox-body">
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
					<?php foreach($Barang as $b){
						$id = json_encode(strtoupper($b->id_barang));
					?>
					<tr>
						<td><?= ++$page ?></td>
						<td>
							<div class="dropdown">
								<button onclick='toggleDiv(<?= $id ?>)' style="cursor:pointer" class='btn btn-primary font-weight-bold btn dropdown-toggle' type="button" id='dropdownMenuButton-<?php echo $b->id_barang ?>' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Dropdown
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
						
						<td><?php echo $b->id_barang ?></td>
						<td><?php echo $b->nama_barang ?></td>
						<td><?php echo $b->nama_jenis ?></td>
						<td><?php echo $b->stok ?></td>
						<td><?php echo $b->nama_satuan ?></td>
						
						<td>
							<a onclick=return href="<?= base_url('barang/edit/') . $b->id_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
							<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/hapus_data/') . $b->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
						</td>
					</tr>
					<tr style="display:none;" id="toggleDiv-<?php echo $b->id_barang ?>" class=" nested-table-container" width="100%">
						<td colspan='8'>
							<p style="text-align:center;">
								<a href="<?= base_url('detail_barang/tambah/'). $b->id_barang  ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Detail Barang <?= $b->id_barang ?> </a>
							</p>
							<table style="background-color:#D3D3D3;" class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>ID Barang</th>
										<th>ID Detail Barang</th>
										<th>Serial Code</th>
										<th>Lokasi</th>
										<th>Keterangan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$nom = 1;
									// var_dump($DetailBarang);
									foreach($DetailBarang as $detail){
										if($detail->id_barang === $b->id_barang){
									?>
										<tr>
											<td><?php echo $nom++ ?></td>
											<td><?php echo $b->id_barang ?></td>
											<td><?php echo $detail->id_detail_barang ?></td>
											<td><?php echo $detail->serial_code?></td>
											<td><?php echo $detail->lokasi?></td>
											<td><?php echo $detail->keterangan?></td>
											<td>
											
											<a onclick=return href="<?= base_url('detail_barang/edit/') . $detail->id_detail_barang ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i></a>
											<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detail_barang/hapus_data/') . $detail->id_detail_barang.'/'.$detail->id_barang ?>"class="btn btn-danger" id="deletebarang" title="Hapus" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
										</tr>
									<?php 
										}
									}
									?>
								</tbody>
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
