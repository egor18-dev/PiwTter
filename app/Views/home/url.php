<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<div class="container-sm p-5 border border-gray rounded mt-5">
    <h5 class="fw-normal text-uppercase mb-3">Introdueix la teva url de visualització</h5>
    <?= form_open('/updateUrl', ['id' => 'frmUsers']) ?>
    <div class="form-group mt-3">
        <?= form_input(['type' => 'text', 'name' => 'url', 'class' => 'form-control', 'placeholder' => 'Introdueix el teu usuari', 'value' => $url]) ?>
    </div>
    <div class="form-group mt-3">
        <?= form_submit('btnSubmit', 'Actualitzar', ['class' => 'btn btn-outline-dark']) ?>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>