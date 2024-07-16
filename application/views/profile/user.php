<div class="page-heading">
    <h1 class="page-title">My Profile</h1>
</div>
			
<!--<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-6 offset-md-4">
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <hr>
                    <div class="form-group">
                        <label for="name">Nama:</label>
						<?php if ($user['is_active'] == 1) : ?>
                            <input type="text" class="form-control" id="name" value="<?= $user['name'] ?>" readonly>
                        <?php else : ?>
                            <input type="text" class="form-control" id="name" value="Data tidak tersedia" readonly>
                        <?php endif; ?>-->
						
                        <!--<?php if ($user !== null) : ?>
                            <input type="text" class="form-control" id="name" value="<?= $user['name'] ?>" readonly>
                        <?php else : ?>
                            <input type="text" class="form-control" id="name" value="Data tidak tersedia" readonly>
                        <?php endif; ?>-->
                    <!--</div>-->
                    <!--<div class="form-group">
                        <label for="email">Email:</label>
                        <?php if (!empty($user) && isset($user['email'])) : ?>
                            <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" readonly>
                        <?php else : ?>
                            <input type="email" class="form-control" id="email" value="Data tidak tersedia" readonly>
                        <?php endif; ?>
                    </div>-->
                    <!-- Tambahkan field tambahan sesuai kebutuhan -->
                <!--</div>
            </div>
        </div>
    </div>
</div>-->

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-6 text-gray-800"></h1>

    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-3 col-lg-8">
        <div class="row no-gutters">
            <div class="mb-2 mt-2 col-md-4">
                <!--<img src="<?= base_url('assets'); ?>/img/mdr.png" /" class="card-img" width="75px">-->
				<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2><p class="card-text"><?= $user['name']; ?></p></h2>
                    <h3><p class="card-text"><?= $user['email']; ?></p></h3>
					<tr>
                    <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']); ?></small></p>
					
					<!--<div class="row">-->
                        <div class="row float-right">
                        <div class="col-md-12">
						<a onclick=return href="<?= base_url('profile/edit/') ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i> Edit</a>
						<tr> </tr>
						<a onclick=return href="<?= base_url('profile/changepassword/') ?>" class="btn btn-warning" title="Edit"><i class="ti ti-pencil"></i> Ubah Password</a>
							<!--<button onclick=return href="<?= base_url('profile/edit/') ?>" class="btn btn-warning" style="cursor: pointer;"><i class="ti ti-pencil"></i> Edit</button>-->
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

