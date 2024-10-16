<div class="page-heading">
    <h1 class="page-title">Jenis Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
				<a href="<?= base_url('jenis/tambah_jenis') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Jenis</a>
			</div>
			<div class="col-md-5">
				<form action="<?= base_url('jenis'); ?>" style="display:flex;" method="post">
					<input type="text" class="form-control" name="keywordJEN" placeholder="Nama Jenis Barang. . . . . . .">
					<button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;"><i class="ti ti-search"></i></button>
					<button type="submit" style="cursor: pointer;" class="btn btn-danger" name="reset" value="1"><i class="fa fa-refresh"></i></button>
				</form>
			</div> 
        </div>
		<?php
		if($keywordJEN){
		?>
			<p style="padding:7px 0 0 1.2em;">Keyword yang sedang dicari : <b><?= $keywordJEN ?></b></p>
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
						<th>Jenis Barang</th>
						<th>Aksi</th>
					</tr>
					<?php 
					$no = 1;
					foreach($jenis as $j){
						?>
						<tr>
							<td><?= ++$page ?></td>
							<td><b><?= $j->nama_jenis ?></b></td>
							<td>
								<a href="<?= base_url('Jenis/edit_data/') . $j->id_jenis ?>" class="btn btn-warning"><i class="ti ti-pencil"></i></a>
								<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Jenis/hapus_data/') . $j->id_jenis ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php } ?>
				</thead>
			</table>
			<?= $pagination ?>
		</div>
	</div>
</div>

