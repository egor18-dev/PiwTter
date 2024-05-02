<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
<div class="row justify-content-center w-100">
    <div class="col-lg-6 text-center">
        <img src="<?php echo $google_chart_api_url; ?>" alt="<?php echo "prova"; ?>">
        <h2>Google2FA</h2>
    </div>
</div>
<?= $this->endSection() ?>