<div class="content">
    <div class="brand">
        <br></br>
        <h1 class="link" href="<?= base_url('auth') ?>">INIT MDR v0</h1>
    </div>

    <?= $this->session->flashdata('message') ?>
    <form id="login-form" action="<?= base_url('auth') ?>" method="post">
        <h2 class="login-title">Log in</h2>
        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
                <input type="text" class="form-control form-control-lg" placeholder="Username" name="name" value="<?= set_value('username')  ?>">
                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit">Login</button>
        </div> 
    </form>
</div>
