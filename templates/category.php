<div class="categoryDiv">
    <h1><?= sanitize_input($cat->get_name()) ?></h1>
    <?php $cat->display_forums($link); ?>
</div>