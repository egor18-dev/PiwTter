<?= $this->extend('main') ?>
<?=$this->section('content')?>
<div class="container-fluid d-flex align-items-center justify-content-center p-5" 
    style="background-image: url('https://images5.alphacoders.com/113/1138652.jpg');
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
    height: 30vh;">
    <h1 class="fw-normal text-uppercase text-white">Piwtter</h1>
</div>
<div class="container-fluid d-flex align-items-center justify-content-center p-3 bg-dark">
    <nav>
        <a href="/add" class="text-white">Afegir publicació</a>
    </nav>
</div>
<div class="container-fluid p-5">
    <div class="row align-items-top justify-content-center">
        <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php echo $post->text; ?>
                            <?=form_open('/addPost', ['id' => 'frmUsers'])?>
                            <textarea name="data"></textarea>
                            <?=form_hidden('post_id', $post->id)?>
                            <div class="form-group mt-3">
                                <?=form_submit('btnSubmit', 'Comentar', ['class' => 'btn btn-outline-dark'])?>
                            </div>
                            <?=form_close()?>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?= base_url('assets/ckeditor/build/ckeditor.js') ?>"></script>

    <script>
        document.querySelectorAll('textarea').forEach((elem) => {
            ClassicEditor
            .create( elem)
            .catch( error => {
                console.error( error );
            } );
        });
        
    </script>

<?=$this->endSection()?>