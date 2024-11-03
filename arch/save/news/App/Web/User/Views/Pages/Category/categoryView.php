<div class="menu">

	<div class="menu-burger"><img class="menu-image" src="/icons/list.svg" alt="Menu"></div>
  <nav class="go-home"><a href="/"><img class="home-image" src="/icons/home-page.svg" alt="Home"></a></nav>
  <p class="menu-label">GonoMax</p>
  <ul class="category-tree">
     <?php echo App\Web\User\Controllers\CategoryController::Index();?>	
  </ul>
</div>
