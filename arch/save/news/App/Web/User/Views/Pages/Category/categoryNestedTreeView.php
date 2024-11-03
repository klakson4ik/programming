	<li class="category-branch">
      <a href="/<?php echo $branch['alias']; ?>">
        <h3 class="category-branch-text">
					  <?php echo $branch['name']; ?>
        </h3>
      </a>
      <?php if(isset($branch['children'])): ?> 
        <ul class="category-tree-element">
      <?php foreach ($branch['children'] as $key=>$element){
              $this->createBranch($element, $key);
           }; ?>
        </ul>
      <?php endif; ?>
	</li>
