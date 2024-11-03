<?php $article = $this->getData()['article']['article'];
      $related = $this->getData()['related']['articles'];
?>

<div id="news">
  <div class="news-title"><?php echo $article["title"]; ?></div>
  <div class="news-image-top">
    <img src="<?php echo $article["image_full"] ?>">
  </div>
      <div class="news-text"><?php echo $article["text"]; ?></div>
  <div class="news-source-link">
     <a href="<?php echo $article["url"];?>"><img class="url-icon" src="/icons/url.svg" alt="url">Source url</a>
  </div>
  <div class="widget-share">
	  <?php require_once USER . WIDGETS . '/Social/Share/ShareView.php' ;?>	
  </div>
</div>
<div class="home">
  <?php foreach($related as $key=>$rel): ?>
    <div class="home-article">
    <a href="/news/index?id=<?php echo $key; ?>">
      <div class="home-article-block">
        <div class="home-article-image" style="background-image: url(<?php echo $rel["image_full"]; ?>)" alt="<?php echo $rel["image_alt"]; ?>"></div>
        <div class="home-article-text"><?php echo $rel["title"]; ?></div>
      </div>
    </a>
    </div>
  <?php endforeach; ?>
</div>
