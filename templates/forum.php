<h3><a href="view_forum.php?f=<?= $forum['id'] ?>"><?= sanitize_input($forum['name']) ?></a></h3>
<p>Topic Count: <?= $topic_count ?></p>
<p>Reply Count: <?= $post_count ?></p>
<p>Last Post By: <?= $username ?> At <?= $last_post_time ?></p>