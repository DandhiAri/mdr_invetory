<div class="page-heading">
    <h1 class="page-title">Data Satuan Barang</h1>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">
                <a href="<?= base_url('Satuan/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah satuan</a>
            </div>
        </div>
		<?php if ($this->session->flashdata('failed')): ?>
			<div class="warn err">
				<div class="msg" onclick="warnError()">
					<?= $this->session->flashdata('failed'); ?>
				</div>
			</div>
		<?php elseif($this->session->flashdata('success')): ?>
			<div class="warn succ">
				<div class="msg" onclick="warnError()">
					<?= $this->session->flashdata('success'); ?>
				</div>
			</div>
		<?php endif; ?>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($Satuan as $S) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><b><?= $S->nama_satuan ?></b></td>
                            <td>
                                <a href="<?= base_url('satuan/edit_data/' . $S->id_satuan) ?>" class="btn btn-warning" title="Edit satuan"><i class="ti ti-pencil"></i></a>
                                <a href="<?= base_url('satuan/hapus_data/' . $S->id_satuan) ?>" class="btn btn-danger" onclick="alert('Apakah anda yakin ingin menghapus?')" id="deletesatuan" title="Hapus satuan" style="cursor: pointer;"><i class="ti ti-trash"></i></button>
                            </td>
                        </tr>
                        </tr>
                </thead>
                <tbody>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
