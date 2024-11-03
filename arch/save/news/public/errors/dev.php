<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Error</title>
      <link type="text/css" rel="stylesheet" href="/public/css/development.css" />
   </head>
   <body id="body">
      <p><b>Код: </b><?= $errno ?></p>
      <p><b>Текст: </b><?= $errstr ?></p>
      <p><b>Файл: </b><?= $errfile ?><b> Строка: </b><?= $errline ?></p>
   </body>
</html>
