<!doctype html>

<html lang="en">
<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<?= $this->getMeta(); ?>	
	<link rel="stylesheet" type="text/css" href="/css/admin.min.css">
</head>

<body id="wrapper">

	<header id="wrapper-header">
		<?php require_once ADMIN . PARTIALS . '/default/header/header.php' ;?>	
	</header>

	<div id="wrapper-content">
   	<?=$content; ?>
	</div>

	<footer id="wrapper-footer">
		<?php require_once ADMIN . PARTIALS . '/default/footer/footer.php' ;?>	
	</footer>

<script src="/js/admin.min.js"></script>
</body>
</html>
