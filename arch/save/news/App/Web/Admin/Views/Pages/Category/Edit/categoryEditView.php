<?php $data = $this->getData(); ?>

<div id="category-edit">
  <form action="/admin/category/<?php echo $data['category']['id'];?>" method="post">
    <input type="text" name="name" value="<?php echo $data['category']['name'] ?>">
    <input class="category-edit-form-parent" type="hidden" name="parent_id" value="<?php echo $data['category']['parent_id'] ?>">  
    <input type="hidden" name="_method" value="PATCH">
    <a href="/admin/category">cancel</a>
    <input type="submit" value="apply">
  </form>
    <div class="category-edit-change">
      <h3 class="category-edit-change-text">parent: <?php echo $data['parent']['name'] ?></h3>
      <h3 class="category-edit-change-newtext"></h3>
      <button class="category-edit-change-btn">change</button>
    </div>

    <ul class="category-edit-tree">
      <?php echo $data['tree']; ?>
    </ul>
</div>
