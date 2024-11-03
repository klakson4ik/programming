<?php $data = $this->getData();?>
<div id="category-create">
  <form class="category-create-form" action="/admin/category" method="post">
    <input class="category-create-input" type="text" name="name">
    <input type="hidden" name="parent_id" value="<?php echo $data; ?>"> 
    <input type="submit" value="apply">
  </form>
</div>
