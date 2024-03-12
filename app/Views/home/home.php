<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<div class="container-fluid d-flex align-items-center justify-content-center p-5" style="background-image: url('https://images5.alphacoders.com/113/1138652.jpg');
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
        <?php foreach ($posts as $post) : ?>
            <?php if ($post->parent_id === null) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php echo $post->text; ?>
                            <?php echo "(" . $post->created_at . ")" ?>
                            <?php if ($user_id === $post->user_ref_id) : ?>
                                <div class="row w-100 justify-content-center align-items-center py-3 mx-auto">
                                    <div class="col-lg-12 m-0 p-0">
                                        <?php echo form_open(base_url("removePost"), ['method' => 'post']); ?>
                                            <?php echo form_hidden('uuid', $post->id); ?>
                                            <?php echo form_submit('btnDelete', 'Editar', ['class' => 'btn btn-outline-dark w-100']); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="col-lg-12 m-0 p-0">
                                        <?php echo form_open(base_url("removePost"), ['method' => 'post']); ?>
                                            <?php echo form_hidden('uuid', $post->id); ?>
                                            <?php echo form_submit('btnDelete', 'Eliminar', ['class' => 'btn btn-outline-danger my-2 w-100']); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="col-lg-12 m-0 p-0">
                                        <?php echo form_open(base_url("removePost"), ['method' => 'post']); ?>
                                            <?php echo form_hidden('uuid', $post->id); ?>
                                            <?php echo form_submit('btnDelete', $post->is_public ? 'Public' : 'Privat', ['class' => 'btn btn-outline-success w-100']); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>      
                            <?php endif; ?>
                            <h6>Comentaris: </h6>
                            <?php foreach ($posts as $comment) : ?>
                                <?php if ($comment->parent_id === $post->id) : ?>
                                    <div class="border border-dark rounded p-3 m-3">
                                        <?php
                                        if (!empty($comment->text))
                                            echo $comment->text;
                                        ?>

                                        <?php if($comment->user_ref_id === $user_id) : ?>
                                            <?php echo form_open(base_url("removePost"), ['method' => 'post']); ?>
                                                <?php echo form_hidden('uuid', $comment->id); ?>
                                                <?php echo form_submit('btnDelete', 'Eliminar', ['class' => 'btn btn-outline-danger w-100']); ?>
                                            <?php echo form_close(); ?>
                                        <?php endif; ?>    
                                        
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?= form_open('/addPost', ['id' => 'frmUsers']) ?>
                            <textarea name="data"></textarea>
                            <?= form_hidden('post_id', $post->id) ?>
                            <div class="form-group mt-3">
                                <?= form_submit('btnSubmit', 'Comentar', ['class' => 'btn btn-outline-dark']) ?>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?= base_url('assets/ckeditor/build/ckeditor.js') ?>"></script>

<script>
    document.querySelectorAll('textarea').forEach((elem) => {
        ClassicEditor
            .create(elem)
            .catch(error => {
                console.error(error);
            });
    });
</script>

<?= $this->endSection() ?>