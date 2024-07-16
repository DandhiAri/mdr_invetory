<div class="content">
    <div class="brand">
        <br></br>
        <h1 class="link" href="<?= base_url('auth') ?>">PT Mangli Djaya Raya</h1>
    </div>

    <?= $this->session->flashdata('message') ?>
    <form id="login-form" action="<?= base_url('auth') ?>" method="post">
        <h2 class="login-title">Log in</h2>
        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email" value="<?= set_value('email')  ?>">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit">Login</button>
        </div>
		<div class="text-center">Don't Have Account Yet?
            <a class="color-blue" href="<?= base_url('auth/registration') ?>">Registration here</a>
		</div>
    </form>
</div>