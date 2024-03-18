<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row w-100 align-items-center justify-content-center mt-5">
        <div class="col-lg-3">
            <form action="<?= base_url('userdemo/add2fa') ?>" method="POST" class="d-flex flex-column">
                <?= csrf_field(); ?>

                <img src="data:image/png;base64, <?php echo $qrcode_image; ?> " class="w-100 h-100"/>


                <label for="txt2FA">Fes scan i confirma el segon factor d'autenticació</label>
                <input type="text" name="txt2FA" id="txt2FA" class="my-3">


                <input type="submit" class="btn btn-outline-dark" value="Activate">

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>