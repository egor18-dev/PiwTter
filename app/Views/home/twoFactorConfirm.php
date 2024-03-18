<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row w-100 align-items-center justify-content-center text-center">
        <div class="col-lg-3">
        <form action="<?= base_url('tryTwoFactor') ?>" method="POST">
            <?= csrf_field(); ?>
            <label for="txt2FA text-dark fw-bold">Segon factor autenticació</label>
            <input type="text" class="my-3" name="txt2FA" id="txt2FA" >
            <input class="btn btn-outline-dark" type="submit" value="Entrar">
        </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

