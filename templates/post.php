<div class="row text-right pb-5 pt-1 <?= $classes[$counter] ?>">
  <div class="col-9">
    <p id="<?= $post->getId() ?>">
      <a class="<?= explode(" ", $classes[$counter])[1] ?>" href="#<?= $post->getId() ?>"><strong><?= sanitize_input($post->getTitle()) ?></strong></a>
      <?php
        if ($post->isPinned()) {
          echo " --- PIN";
        }
      ?>
    </p>
    <p>נכתב על ידי <strong><?= sanitize_input($author) ?></strong> בתאריך <?= format_time($post->getCreationTime()) ?></p>
    <p><?= sanitize_input($post->getContent()); ?></p>
    <?php
      if ($post->getEditTime() !== $post->getCreationTime()) {
    ?>
        <p>נערך בתאריך <?= format_time($post->getEditTime()) ?></p>
    <?php
      }
    ?>
  </div>
  <div class="col-3">
    <p><strong><?= sanitize_input($author) ?></strong></p>
    <p>הצטרף בתאריך <?= format_time($register_date) ?></p>
  </div>
</div>