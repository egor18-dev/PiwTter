<?= $this->extend('main') ?>
<?=$this->section('content')?>
    <div class="container-sm p-5 border border-gray rounded mt-5">
        <h5 class="fw-normal text-uppercase mb-3">Crea el teu compte</h5>
        <?=form_open('create_user.php', ['id' => 'frmUsers'])?>
        <div class="form-group">
            <?=form_input(['type' => 'text', 'name' => 'name', 'class' => 'form-control', 'placeholder' => 'Introdueix el teu nom'])?>
        </div>
        <div class="form-group mt-3">
            <?=form_input(['type' => 'email', 'name' => 'email', 'class' => 'form-control', 'placeholder' => 'Introdueix el teu correu electrònic'])?>
        </div>
        <div class="form-group mt-3">
            <?=form_input(['type' => 'password', 'name' => 'password', 'class' => 'form-control', 'placeholder' => 'Introdueix la teva contrasenya'])?>
        </div>
        <div class="form-group mt-3">
            <?=form_submit('btnSubmit', 'Registrar', ['class' => 'btn btn-outline-dark'])?>
        </div>
        <?=form_close()?>
    </div>
<?=$this->endSection()?>