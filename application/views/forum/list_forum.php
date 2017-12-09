<script type="text/javascript">
function timeSince(date) {
  if (typeof date !== 'object') {
    date = new Date(date);
  }

  var seconds = Math.floor((new Date() - date) / 1000);
  var intervalType;

  var interval = Math.floor(seconds / 31536000);
  if (interval >= 1) {
    intervalType = 'year';
  } else {
    interval = Math.floor(seconds / 2592000);
    if (interval >= 1) {
      intervalType = 'month';
    } else {
      interval = Math.floor(seconds / 86400);
      if (interval >= 1) {
        intervalType = 'day';
      } else {
        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
          intervalType = "hour";
        } else {
          interval = Math.floor(seconds / 60);
          if (interval >= 1) {
            intervalType = "minute";
          } else {
            interval = seconds;
            intervalType = "second";
          }
        }
      }
    }
  }

  if (interval > 1 || interval === 0) {
    intervalType += 's';
  }

  return interval + ' ' + intervalType;
}
</script>

<div class="row">
<div class="col-md-4">
  <div class="shadow-box" style="padding: 20px;">
      <a class="nav-link btn btn-primary" href="<?= base_url()?>forum/ask"> New Topic
        <span class="sr-only">(current)</span>
      </a>
      <div class="kotak-cari" style="margin-top: 10px;">
        <form method="post" action="<?= base_url().'forum/search'?>">
          <input class="form-control" placeholder="Looking for a topics?" type="text" name="search-term">
          <button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </form>
      </div>
  </div>
</div>

<div class="col-md-8 col-xs-8">
<!-- <?php var_dump($forum); ?> -->
<?php if (empty($forum)) {
  echo 'No forum available';
}else{ $i=0; foreach ($forum as $for) { $i++;?>
  

  <div class="shadow-box">
    <div class="identity">
      <div class="img" style="background-image: url('<?= base_url()?>assets/gambar/user.png'); background-size: 100%; background-position: center;"></div>
      <div class="identity-text">
        <span style="font-size: 15px;">User satu</span><br>
        <span style="font-size: 13px; color: grey"><span id="timesince<?= $i; ?>"></span>  ago</span>
        
        <script type="text/javascript">document.getElementById("timesince<?= $i; ?>").innerHTML = timeSince(new Date('<?= $for['timestamp'];?>'));</script>

      </div>
    </div>
    <div class="forum-box-title">
      <a href="<?= base_url().'forum/show/'.$for['forum_id'].'/'.$for['title_slug']?>"><h5><?= $for['title'] ?></h5></a>
      <div class="forum-ans">
        <span><i class="fa fa-commenting" aria-hidden="true"></i></span><span> <?= $for['num']; ?> answers</span>
      </div>
      <div class="forum-ans">
        <span> <i class="fa fa-chevron-up" aria-hidden="true"></i> <?= $for['vote']; ?> Votes</span>
      </div>

<?php 
  $tag_html = array_map('trim', explode(',', $for['tags']));
  // var_dump($tag_html);
?>

      <div class="forum-category">
      <?php foreach ($tag_html as $t) { ?>      
        <a href="<?= base_url().'forum/tags/'.$t; ?>"><span style="font-size: 10px;"><?= strtoupper($t) ?></span></a>
      <?php } ?>
      </div>
    </div>
<!--     <div class="forum-detail">
      <div class="forum-view">
        <div class="vote">
          <a href=""><span style="color: grey;font-size: 25px"><i class="fa fa-chevron-up" aria-hidden="true"></i></span><br>
          <span style="color: black; font-size: 13px">89</span></a>
        </div>
        <div class="vote">
          <a href=""><span style="color: grey;font-size: 25px"><i class="fa fa-chevron-down" aria-hidden="true"></i></span><br>
          <span style="color: black; font-size: 13px">89</span></a>
        </div>
      </div>
    </div> -->
  </div>
<?php }} ?>

</div>
</div>