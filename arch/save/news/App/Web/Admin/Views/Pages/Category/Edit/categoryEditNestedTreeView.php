
	<li class="category-edit-branch">
		  <div class="category-edit-branch-content">
           <h3 class="category-edit-branch-text"><?php echo $branch['name']; ?></h3>
           <h1 class="category-edit-branch-plus" data-id="<?php echo $key; ?>">+</h1>
		  </div>
      <?php if(isset($branch['children'])): ?> 
        <ul class="category-edit-tree-element">
      <?php foreach ($branch['children'] as $key=>$element){
              $this->createBranch($element, $key);
           }; ?>
        </ul>
      <?php endif; ?>
	</li>
