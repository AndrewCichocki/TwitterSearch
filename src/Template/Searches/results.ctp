<h3>Search results for '<?= h($search->term) ?>'</h3>
<div>
  <?php if (!empty($search->tweets)): ?>
    <section id="cd-timeline" class="cd-container">
      <?php foreach ($search->tweets as $tweet): ?>
      <div class="cd-timeline-block">
    	  <div class="cd-timeline-img cd-twitter">
    		  <i class="fa fa-twitter fa-fw fa-2x"></i>
    		</div> <!-- cd-timeline-img -->

    		<div class="cd-timeline-content">
    			<div class="panel panel-info">
    				<div class="panel-heading">
    					<h3 class="panel-title">
    						<a href="<?= h($tweet->profile_url) ?>" target="_blank">
    						  <?= h($tweet->profile_name) ?>
    						</a>
    						<span class="tweet-stats">
    							<i class="fa fa-retweet"></i> <?= h($tweet->retweet_count) ?>
    							<i class="fa fa-heart"></i> <?= h($tweet->favorite_count) ?>
    						</span>
    					</h3>
    				</div>
    				<div class="panel-body">
    					<a href="<?= h($tweet->tweet_url) ?>" target="_blank">
    					  <?= h($tweet->tweet_text) ?>
    				  </a>
    			  </div>
    			</div>
    			<span class="cd-date">
    				<span class="cd-date-text">
    				  <?= h($tweet->created_at->format(DATE_RFC850)) ?>
    			  </span>
    		  </span>
    	  </div> <!-- cd-timeline-content -->
    	</div> <!-- cd-timeline-block -->
      <?php endforeach; ?>
    </section> <!-- cd-timeline -->
  <?php else: echo 'No results found'; endif; ?>
</div>
