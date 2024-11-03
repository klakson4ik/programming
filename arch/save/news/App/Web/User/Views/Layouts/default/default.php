<!doctype html>

<html lang="en">
<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
  <link rel="manifest" href="/favicons/site.webmanifest">
  <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#356993">
  <link rel="shortcut icon" href="/favicon.ico">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="msapplication-config" content="/favicons/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">

  <meta name="apple-mobile-web-app-title" content="gonomax">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?= $this->getMeta(); ?>	
  <?php if(isset($_GET['id'])): ?>
    <?php echo $_SESSION['facebook']; ?>
    <?php echo $_SESSION['twitter']; ?>
  <?php endif; ?>
	<link rel="stylesheet" type="text/css" href="/css/app.min.css">

   <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-EZ1NXQJFMF"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-EZ1NXQJFMF');
  </script>

</head>

<body id="wrapper">

	<header id="wrapper-header">
		<?php require_once USER . PARTIALS . '/default/header/header.php' ;?>	
	</header>

	<main id="wrapper-content">
   	    <?php echo $content; ?>
    </main>

	<footer id="wrapper-footer">
		<?php require_once USER . PARTIALS . '/default/footer/footer.php' ;?>	
	</footer>

  <script src="/js/app.min.js"></script>
</body>
</html>
