<?php include 'Koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Edit Data Replace
            </div>
        </div>
        <div class="ibox-body">
            <form action="<?= base_url('Replace/proses_edit_replace')?>" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="nama" class="form-label">PIC</label>
							<input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama..."value="<?= $Replace['nama'] ?>">
							<input type="hidden" name="id_replace" id="id_replace" value="<?= $Replace['id_replace'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select class="form-control" name="status" id="status" placeholder="Pilih Status...">
								<?php
								$status_options = ['Requested', 'Finished', 'Rejected'];
								foreach ($status_options as $option) {
									$selected = ($Replace['status'] == $option) ? 'selected' : '';
									echo "<option value='$option' $selected>$option</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="tgl_replace_update" class="form-label">Waktu Update Replace</label>
							<input type="datetime-local" class="form-control" name="tgl_replace_update" id="tgl_replace_update" value="<?= $Replace['tgl_replace'] ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="keterangan" class="form-label">keterangan</label>
							<input type="text" class="form-control" name="keterangan" id="keterangan" min="1"value="<?= $Replace['keterangan'] ?>">
						</div>
					</div>
					<div class="row float-right">
						<div class="col-md-12">
							<a href="<?= base_url('Replace') ?>" class="btn btn-danger" id="deletereplace" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
							<button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
