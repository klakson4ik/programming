<?php $articles = $this->getData()['pages'];
      $pagination = $this->getData()['view']; ?>



<section class="home">
  <?php foreach($articles as $key=>$article): ?>
    <div class="home-article">
    <a href="news/index?id=<?php echo $key; ?>">
      <div class="home-article-block">
        <div class="home-article-image" style="background-image: url(<?php echo $article["image_full"]; ?>)" alt="<?php echo $article["image_alt"]; ?>"></div>
        <div class="home-article-text"><?php echo $article["title"]; ?></div>
      </div>
    </a>
    </div>
  <?php endforeach; ?>
</section>
<div><?php echo $pagination ;?> </div>
