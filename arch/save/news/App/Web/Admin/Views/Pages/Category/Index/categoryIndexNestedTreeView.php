
<?php if(!isset($branch['children'])): ?> 
	<li class="category-branch" color="grey">
<?php else: ?>
	<li class="category-branch">
<?php endif; ?>
    <div class="category-branch-content">
		  <h3 class="category-branch-text">
			  <?php echo $branch['name']; ?>
      </h3>
        <a href="/admin/category/edit/<?php echo $key; ?>"class="category-branch-edit">edit</a>
      <a href="/admin/category/create?parent_id=<?php echo $key; ?>" class="category-branch-add">create</a>
      <?php if(!isset($branch['children'])): ?> 
      <form action="/admin/category/<?php echo $key; ?>" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="delete">
      </form>
      <?php endif; ?>
    </div>
      <?php if(isset($branch['children'])): ?> 
        <ul class="category-tree-element">
      <?php foreach ($branch['children'] as $key=>$element){
              $this->createBranch($element, $key);
           }; ?>
        </ul>
      <?php endif; ?>
	</li>


