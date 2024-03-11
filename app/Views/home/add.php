<?= $this->extend('main') ?>
<?=$this->section('content')?>

    <div class="container-sm min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <form action="<?= base_url('addPost') ?>" method="post" class="border border-dark rounded p-3 w-100">
            <h5>Afegir publicació</h5>
            <textarea id="ID_TEXTAREA" name="data"></textarea>
            <input type="submit" class="btn btn-outline-dark mt-2" value="Publicar">
        </form>
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