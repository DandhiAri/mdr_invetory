<?php include 'koneksi.php' ?>
<div class="page-heading">
    <h1 class="page-title"><?= $title ?></h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                Form Tambah Data Detail Replace
            </div>
        </div>
		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php endif; ?>
        <div class="ibox-body">	
            <form action="<?= base_url('Detail_Replace/proses_tambah_detail/'.$id)?>" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="id_replace" class="form-label">ID Replace</label>
							<input type="text" class="form-control" name="id_replace" id="id_replace" placeholder="ID Replace..." value="<?= $id ?>" readonly> 
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label  class="form-label">ID Barang</label>
							<select class="form-control" name="id_barang" id="getIdBarang" required>
								<option value="" >Pilih Barang</option>
								<?php foreach ($Barang as $b){ ?>
									<option value="<?= $b->id_barang ?>"><?= $b->nama_barang ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Serial Number</label>
							<select class="form-control" name="serial_code" id="showSerialCode" required>
								<option value="">Pilih Nomor Seri</option>
								
							</select>
							<input type="text" name="id_detail_barang" id="id_detail_barang" hidden>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="qtty" class="form-label">Jumlah</label>
							<input type="number" class="form-control" name="qtty" id="qtty" placeholder="Masukkan Kuantitas Barang..." required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="lokasi" class="form-label">Lokasi</label>
							<input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan Kuantitas Barang..." required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan...">
						</div>
					</div>
					<div class="row float-right">
						<div class="col-md-12">
							<a href="<?= base_url('replace') ?>" class="btn btn-danger" style="cursor: pointer;"><i class="ti ti-reload"></i> Kembali</a>
							<button type="submit" class="btn btn-success" id="simpanreplace" style="cursor: pointer;"><i class="ti ti-save"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
