<div class="content">
    <div class="brand">
        <br></br>
        <h1 class="link" href="<?= base_url('auth') ?>">PT Mangli Djaya Raya</h1>
    </div>
<!--<div class="content">
    <div class="brand">
        <a class="link" href="index.html">PT Mangli Djaya Raya</a>
    </div>-->
    <form id="register-form" action="<?= base_url('auth/registration'); ?>" method="post">
        <h2 class="login-title">Sign Up</h2>

        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Name" autocomplete="off">
            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
            <input class="form-control" id="password" type="password" name="password1" placeholder="Password">
            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>

        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password2" placeholder="Confirm Password">
        </div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit">Sign up</button>
        </div>

        <div class="text-center">Already a member?
            <a class="color-blue" href="<?= base_url('auth') ?>">Login here</a>
        </div>
    </form>
</div>
