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
					<input type="text" class="form-control" name="keywordPNJ" placeholder="Ketik keyword disini . . . . . . . . . . . . . . . . . . .">
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
                        <th>ID </th>
                        <th>Nomer Surat</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama File Surat Pengajuan</th>
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
								<td><b><?= $S->no_surat ?></b></td>
								<td><?= $S->tgl_pengajuan ?></td>
								<td><?= $S->invoice ?></td>
								<td>
									<a href="<?= base_url('pengajuan/viewPDFfile/' . $S->id_pengajuan) ?>" target="_blank" class="btn btn-primary" title="Download Dokumen"><i class="fa fa-file-text"></i></a>
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
