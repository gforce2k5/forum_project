<div class="row text-right pb-5 pt-1 <?= $classes[$counter] ?>">
  <div class="col-9">
    <?php
      if ($edit) {
    ?>
        <form action="functions/edit_post.php" method="post" id="<?= $post->getId() ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="edit-post-title" name="title" value="<?= $post->getTitle() ?>">
          </div>
          <div class="form-group">
            <textarea class="form-control" id="edit-post-content" name="content" rows="3"><?= $post->getContent() ?></textarea>
          </div>
          <?php
            if (!$post->getPostId() && ($current_user->get_status() == 2 || $current_user->is_manager($link, $post->getForumId()))) {
          ?>
              <div class="form-group">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="create-post-pin" name="pin"<?= $post->isPinned() ? ' checked' : '' ?>>
                  <label class="form-check-label" for="create-post-pim" style="padding-right: 30px">נעץ את הנושא</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="create-post-lock" name="lock"<?= $post->isLocked() ? ' checked' : '' ?>>
                  <label class="form-check-label" for="create-post-lock" style="padding-right: 30px">נעל את הנושא</label>
                </div>
              </div>
          <?php
            }
            $bb_parser = new bbParser();
          ?>
          <div class="form-group">
            <label for="edit-post-preview">תצוגה מקדימה</label>
            <div class="bbcode-preview" id="edit-post-preview"><?= $bb_parser->getHtml(htmlspecialchars($post->getContent())) ?></div>
          </div>
          <input type="hidden" name="p_id" value="<?= $post->getId() ?>">
          <input type="submit" class="btn btn-primary" value="שמור">
          <a href="view_topic.php?p=<?= $post->getForumId() ? $post->getId() : $post->getPostId() ?>" class="btn btn-secondary">ביטול</a>
        </form> 
    <?php
      } else {
    ?>
      <p id="<?= $post->getId() ?>">
        <a class="<?= explode(" ", $classes[$counter])[1] ?>" href="#<?= $post->getId() ?>"><strong><?= sanitize_input($post->getTitle()) ?></strong></a>
        <?php
          if ($post->isPinned()) {
            echo " --- PIN";
          }
        ?>
      </p>
      <p>נכתב על ידי <strong><?= sanitize_input($author) ?></strong> בתאריך <?= format_time($post->getCreationTime()) ?></p>
      <p><?= $bb_parser->getHtml(sanitize_input($post->getContent())); ?></p>
      <?php
        if ($post->getEditTime() !== $post->getCreationTime()) {
      ?>
          <p>נערך בתאריך <?= format_time($post->getEditTime()) ?></p>
      <?php
        }
      }
    ?>
  </div>
  <div class="col-3">
    <p><strong><?= sanitize_input($author) ?></strong></p>
    <p>הצטרף בתאריך <?= format_time($register_date) ?></p>
    <?php
      if (!$edit) {
        $author_id = $post->getAuthorId();
        include "templates/admin_buttons.php";
      }
    ?>
  </div>
</div>