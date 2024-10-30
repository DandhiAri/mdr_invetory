<div class="page-heading">
    <h1 class="page-title">Data Pengajuan Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Pengajuan/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Pengajauan</a>
            </div>
			<div class="col-md-5">
				<form action="<?= base_url('pengajuan'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordPNJ" placeholder="ID pengajuan, Tanggal Pengajuan. . . . . . .">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
        </div>
		<?php
		if($keywordPNJ){
		?>
			<p style="padding:7px 0 0 1.2em;">Keyword yang sedang dicari : <b><?= $keywordPNJ ?></b></p>
		<?php
		}
		?>

		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php elseif($this->session->flashdata('success')): ?>
			<div class="warn succ">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
			</div>
		<?php endif; ?>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pengajuan</th>
                        <th>Tgl Pengajuan</th>
                        <th>invoice</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						$no = 1;
						foreach ($Pengajuan as $S) {
						?>
							<tr>
								<td><?= ++$page ?></td>
								<td><b><?= $S->id_pengajuan ?></b></td>
								<td><?= $S->tgl_pengajuan ?></td>
								<td>
									<button alt="Invoice" class="btn btn-success" style=" cursor: pointer;" data-toggle="modal" data-target="#invoiceModal-<?= $S->id_pengajuan ?>" onclick="showInvoice('')"> Show </button>
									<?= $S->invoice ?>
									<div class="modal fade" id="invoiceModal-<?= $S->id_pengajuan ?>" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="invoiceModalLabel"><?= $S->invoice ?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<img src="<?= base_url('assets/img/bukti/invoice/' . $S->invoice); ?>" id="invoiceImage" class="img-fluid" alt="Invoice Image">
												</div>
											</div>
										</div>
									</div>
								</td>
								<td>
									<a href="<?= base_url('pengajuan/edit_data/' . $S->id_pengajuan) ?>" class="btn btn-warning" title="Edit satuan"><i class="ti ti-pencil"></i></a>
									<a href="<?= base_url('pengajuan/hapus_data/' . $S->id_pengajuan) ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
								</td>
							</tr>
					<?php } ?>	
                </tbody>
            </table>
			<!-- <script>
				function showInvoice(imageUrl) {
					document.getElementById('invoiceImage').src = imageUrl;
				}
			</script> -->
			<?= $pagination ?>
        </div>
    </div>
</div>
