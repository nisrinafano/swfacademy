<div class="row">
<div class="col-md-12">
	<div class="shadow-box" style="padding: 20px;">
		<h4><?= ucfirst($forum['title']); ?></h4>
		<span style="height: 2px; background-color: #e7e7e7; width: 100%; display: block;"></span>
		<div class="row">
		<div class="col-md-8">
			<div class="itemforum-desc">
				<p><?= $forum['content']; ?></p>
			</div>

<?php 
  $tag_html = array_map('trim', explode(',', $forum['tags']));
  // var_dump($tag_html);
?>
			<div class="itemforum-cat forum-category">
			<?php foreach ($tag_html as $t) { ?>      
		        <a href="<?= base_url().'forum/tags/'.$t; ?>"><span style="font-size: 10px;"><?= strtoupper($t) ?></span></a>
		     <?php } ?>
	      	</div>
	      	<div class="itemforum-votes">
				<div class="forum-detail">
			      <div class="forum-view">
			        <div class="vote">
			          <a href="<?= base_url().'forum/new_upvote_forum/'.$forum['forum_id']?>"><span style="color: grey;font-size: 25px"><i class="fa fa-chevron-up" aria-hidden="true"></i></span><br>
			          <span style="color: black; font-size: 13px"><?= $upvote; ?></span></a>
			        </div>
			        <div class="vote">
			          <a href="<?= base_url().'forum/new_downvote_forum/'.$forum['forum_id']?>"><span style="color: grey;font-size: 25px"><i class="fa fa-chevron-down" aria-hidden="true"></i></span><br>
			          <span style="color: black; font-size: 13px"><?= $downvote; ?></span></a>
			        </div>
			      </div>
			    </div>
			</div>
			<div class="itemforum-author">
				<div class="img" style="background-image: url('<?= base_url()?>assets/gambar/user.png'); background-size: 100%; background-position: center;"></div>
				<div class="itemforum-author-text">
					<span>username</span><br>
					<small>Posted <?= date('F jS, Y H:i',strtotime($forum['timestamp']))?></small>
				</div>
			</div>
			<span style="clear: both; display: block;"><?= $num_ans; ?> Answers</span>
			<span style="height: 2px; background-color: #e7e7e7; width: 100%; display: block; float: left; margin: 20px 0;"></span>

			<!-- answerrr --> 
			<!-- <?php var_dump($answer); ?> -->
			<?php if (empty($answer)) {
				echo '<span style="text-align:center; display:block">Still no answer yet</span>';
			}else{ foreach ($answer as $ans) { ?>
			<div class="itemforum-answer">
				<div class="itemforum-peserta">
					<div class="img" style="background-image: url('<?= base_url()?>assets/gambar/user.png'); background-size: 100%; background-position: center;"></div>
					<div class="itemforum-author-text">
						<span>username</span><br>
					</div>
					<div class="itemforum-author-text">
						<small>Posted <?= date('F jS, Y H:i',strtotime($ans['timestamp']))?></small>
					</div>
				</div>
				<div class="itemforum-desc">
					<p><?= $ans['content']?></p>
				</div>
				<div class="itemforum-footer">
					<div class="itemforum-footer-vote">
						<a href="<?= base_url().'forum/new_upvote_answer/'.$forum['forum_id'].'/'.$ans['ans_id']?>"><span><i class="fa fa-chevron-up" aria-hidden="true"></i></span></a>
						<small><?= $ans['upvote'] ?></small>
					</div>
					<div class="itemforum-footer-vote">
						<a href="<?= base_url().'forum/new_downvote_answer/'.$forum['forum_id'].'/'.$ans['ans_id']?>"><span><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
						<small><?= $ans['downvote'] ?></small>
					</div>
					<div class="itemforum-footer-reply">
						
					</div>
				</div>
			</div>
			<?php }} ?>

			<span style="height: 2px; background-color: #e7e7e7; width: 100%; display: block; float: left; margin: 20px 0;"></span>
			<p>Your Answer</p>

			<!-- answ box -->
			<div class="itemforum-answer-box">
				<form method="post" action="<?= base_url().'forum/new_answer/'.$forum['forum_id']?>">
					<div class="form-group">
						<textarea id="text-answer" class="form-control" name="ans-content"></textarea>	
					</div>
					<div class="form-group">
						<input type="submit" name="" value="Post Answer" class="btn btn-primary">
					</div>
				</form>
			</div>

		</div>
		</div>
	</div>
</div>
</div>