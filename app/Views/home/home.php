<?= $this->extend('main') ?>
<?= $this->section('content') ?>
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
        <a href="/twoFactor" class="text-white">2fa</a>
        <a href="/logout" class="text-white">Tancar sessió</a>
    </nav>
</div>
<div class="container-fluid p-5">
    <div class="row align-items-top justify-content-center">
        <?php foreach ($posts as $post) : ?>
            <?php if ($post->parent_id === null) : ?>
                <?php if (!$post->is_public && $post->user_ref_id === $user_id
                 || $post->is_public || in_array("see_all_posts", $permissions)) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="main"><?php echo $post->text; ?></div>
                            <?php
                                $files = explode(" ", $post->files);
                                for($i = 1; $i < count($files); $i++)
                                {
                                    echo form_open(base_url("download"), ['method' => 'post']); 
                                    echo form_hidden('file', $files[$i]);
                                    echo form_hidden('uuid', $post->id);
                                    echo form_submit('btnDelete', "Descarregar " . $files[$i] , ['class' => 'btn btn-outline-dark']); 
                                    echo form_close(); 
                                }
                            ?>
                            <?php echo $post->is_public ? 'Public' : 'Privat'; ?>
                            <?php echo "(" . $post->created_at . ")" ?>
                            <?php if ($user_id === $post->user_ref_id || in_array("delete_all_posts", $permissions)) : ?>
                                <div class="row w-100 justify-content-center align-items-center py-3 mx-auto">
                                    <div class="col-lg-12 m-0 p-0">
                                        <?php echo form_open(base_url("editPost"), ['method' => 'post']); ?>
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
                                        <?php echo form_open(base_url("editData"), ['method' => 'post']); ?>
                                            <?php echo form_hidden('data', $post->text); ?>
                                            <?php echo form_hidden('uuid', $post->id); ?>
                                            <?php echo form_hidden('is_public', $post->is_public); ?>
                                            <?php echo form_hidden('action', "edit"); ?>
                                            <?php echo form_submit('btnDelete', $post->is_public ? 'Public' : 'Privat', ['class' => 'btn btn-outline-success w-100']); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>      
                            <?php endif; ?>
                            <h6>Comentaris: </h6>
                            <?php foreach ($posts as $comment) : ?>
                                <?php if ($comment->parent_id === $post->id) : ?>
                                    <div class="border border-dark rounded p-3 m-3">
                                        <div class="main">
                                        <?php
                                            if (!empty($comment->text))
                                                echo  $comment->text;

                                                $files = explode(" ", $comment->files);
                                                for($i = 1; $i < count($files); $i++)
                                                {
                                                    echo form_open(base_url("download"), ['method' => 'post']); 
                                                    echo form_hidden('file', $files[$i]);
                                                    echo form_hidden('uuid', $comment->id);
                                                    echo form_submit('btnDelete', "Descarregar " . $files[$i] , ['class' => 'btn btn-outline-dark']); 
                                                    echo form_close(); 
                                                }
                                        ?>
                                        </div>

                                        <?php if($comment->user_ref_id === $user_id) : ?>
                                            <?php echo form_open(base_url("editPost"), ['method' => 'post']); ?>
                                                <?php echo form_hidden('uuid', $comment->id); ?>
                                                <?php echo form_submit('btnDelete', 'Editar', ['class' => 'btn btn-outline-dark w-100']); ?>
                                            <?php echo form_close(); ?>
                                            <?php echo form_open(base_url("removePost"), ['method' => 'post']); ?>
                                                <?php echo form_hidden('uuid', $comment->id); ?>
                                                <?php echo form_submit('btnDelete', 'Eliminar', ['class' => 'btn btn-outline-danger w-100']); ?>
                                            <?php echo form_close(); ?>
                                        <?php endif; ?>    
                                        
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?= form_open_multipart('/addPost', ['id' => 'frmUsers', 'enctype' => 'multipart/form-data']) ?>
                            <textarea name="data"></textarea>
                            <?= form_hidden('post_id', $post->id) ?>
                            <div class="form-group mt-3">
                            <?= form_upload(['name' => 'fileInput[]', 'id' => 'fileInput', 'class' => 'form-control', 'multiple' => 'multiple']) ?>
                            </div>
                            <div class="form-group mt-3">
                                 <?=form_hidden('type', 'upload');?>
                                <?= form_submit('btnSubmit', 'Comentar', ['class' => 'btn btn-outline-dark']) ?>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                    <?php endif; ?>
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