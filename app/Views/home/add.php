<?= $this->extend('main') ?>
<?=$this->section('content')?>

    <div class="container-sm min-vh-100 d-flex flex-column align-items-center justify-content-center">
        
        <?=form_open('/addPost', ['id' => 'frmUsers', 'class' => 'border border-dark rounded p-5 w-100'])?>
        <h5 class="mb-3 text-uppercase">Fer publicació</h5>
        <textarea id="ID_TEXTAREA" name="data"></textarea>
        <div class="form-group mt-3">
            <?=form_submit('btnSubmit', 'Afegir', ['class' => 'btn btn-outline-dark'])?>
        </div>
        <?=form_close()?>
        
        <?php if (session()->has('uploadPostErrors')): ?>
        <div class="mt-3 w-100">
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach (session('uploadPostErrors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif ?>
    </div>

    <script src="<?= base_url('assets/ckeditor/build/ckeditor.js') ?>"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#ID_TEXTAREA' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

<?=$this->endSection()?>