<?= $this->extend('main') ?>
<?= $this->section('content') ?>
    <div class="row align-items-center justify-content-center mt-5">
        <div class="col-lg-6 border border-dark rounded p-5">
            <?=$post?>
            <a href="/home" class="btn btn-outline-dark mt-3">Tornar</a>
        </div>
    </div>
<?= $this->endSection() ?>