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
            <form action="<?= base_url('Replace/proses_edit_replace/'.$id)?>" method="POST">
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
							<label for="tgl_replace_update" class="form-label">Waktu Update Replace</label>
							<input type="date" class="form-control" name="tgl_replace" id="tgl_replace" value="<?= $Replace['tgl_replace'] ?>">
						</div>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-md-12">
						<a href="<?= base_url('Replace') ?>" class="btn btn-danger" id="deletereplace" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
						<button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
