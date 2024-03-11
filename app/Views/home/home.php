<?= $this->extend('main') ?>
<?=$this->section('content')?>
<div class="container-fluid d-flex align-items-center justify-content-center p-5" 
    style="background-image: url('https://images5.alphacoders.com/113/1138652.jpg');
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
    height: 30vh;">
    <h1 class="fw-normal text-uppercase text-white">Hola</h1>
</div>
<div class="container-fluid d-flex align-items-center justify-content-center p-3 bg-dark">
    <nav>
        <a href="/add" class="bg-white text-dark rounded p-2 text-uppercase">Afegir publicació</a>
    </nav>
</div>
<div class="container-fluid p-5">
    <div class="row align-items-top justify-content-center">
        <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php echo $post->text; ?>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>

<?=$this->endSection()?>