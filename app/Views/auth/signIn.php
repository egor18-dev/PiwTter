<?= $this->extend('main') ?>
<?=$this->section('content')?>
    <div class="container-sm p-5 border border-gray rounded mt-5">
        <h5 class="fw-normal text-uppercase mb-3">Inicia sesió</h5>
        <?=form_open('create_user.php', ['id' => 'frmUsers'])?>
        <div class="form-group mt-3">
            <?=form_input(['type' => 'text', 'name' => 'user', 'class' => 'form-control', 'placeholder' => 'Introdueix el teu usuari'])?>
        </div>
        <div class="form-group mt-3">
            <?=form_input(['type' => 'password', 'name' => 'password', 'class' => 'form-control', 'placeholder' => 'Introdueix la teva contrasenya'])?>
        </div>
        <div class="form-group mt-3">
            <h6 class="fw-normal mb-3">No tens compte? <a class="fw-bold">Crear compte</a></h6>
            <?=form_submit('btnSubmit', 'Entrar', ['class' => 'btn btn-outline-dark'])?>
        </div>
        <?=form_close()?>
    </div>
<?=$this->endSection()?>