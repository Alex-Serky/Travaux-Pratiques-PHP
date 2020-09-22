<form action="" method="POST" enctype="multipart/form-data">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <div class="row">
        <div class="col-md-9">
            
            </div>
            <div class="col-md-3">
                <?php if ($post->getImage()): ?>
                    <img src="/uploads/posts/<?= $post->getImage() ?>" alt="" style="width: 250px">
                <?php endif ?>

        </div>
    </div>
    <?= $form->file('image', 'Image à la une'); ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <button class="btn btn-primary">
        <?php if ($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>