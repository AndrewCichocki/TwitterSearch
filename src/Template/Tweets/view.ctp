<h1><?= h($tweet->profile_name) ?></h1>
<p><?= h($tweet->tweet_text) ?></p>
<p><small>Created At: <?= $tweet->created_at->format(DATE_RFC850) ?></small></p>
