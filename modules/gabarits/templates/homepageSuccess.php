<?php use_javascript('loopedfader.js') ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#slider ul').loopedFader({
      fadeInSpeed: 500,
      fadeOutSpeed: 500,
      waitTime: 10000,
      slide: 'li',
      beforeSlide: function(current, next){
        $('#slider .pager a').removeClass('active').eq(next).addClass('active');
      }
    });
  });
</script>
<?php include_partial('sfCms/flashes') ?>

<!-- Start main section -->
<section>
  <?php $slider = getHomepageSlider() ?>
  <?php if(count($slider)): ?>
    <!-- Start slider -->
    <div id="slider">
      <div>
        <h2 id="page_title">Informations</h2>
        <ul>
          <?php foreach($slider as $news): ?>
            <li>
              <p><?php echo substr($news['contents'], 0, 780).(strlen($news['contents']) > 780 ? "..." : null) ?></p>
              <?php if($news['url']): ?>
                <a href="<?php echo url_for($news['url']) ?>"<?php if(preg_match('/^http/i', $news['url'])): ?> target="_blank"<?php endif ?> class="follow">Lire la suite...</a>
              <?php endif ?>
            </li>
          <?php endforeach ?>
        </ul>
        <span class="pager">
          <?php for($i = 1; $i <= count($slider); $i++): ?>
            <a<?php if($i-1 <= 0): ?> class="active"<?php endif ?>><?php echo $i ?></a>
          <?php endfor ?>
        </span>
      </div>
    </div>
    <!-- End slider -->
  <?php endif ?>

  <!-- Start contents -->
  <?php echo $sf_data->getRaw('page')->getContents() ?>
  <div class="clear"></div>
  <!-- End contents -->
</section>
<!-- End main section -->