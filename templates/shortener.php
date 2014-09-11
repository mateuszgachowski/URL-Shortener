<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>URL Shortener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1, user-scalable=no">
    <!-- CSS -->
    <link rel="stylesheet" href="/media/css/styles.css?rev=<?php echo $revision;?>">

    <?php include_once("templates/_tracking.php") ?>
  </head>
  <body>
    <div id="container">
      <div class="wrapper">
        <a href="https://chrome.google.com/webstore/detail/url-shortener-ur2pl/ppemampfpejapeopolboncldkbakpdha" class="chrome-ext-promo" target="_blank">
          <img src="/media/gfx/icon128.png" alt="ur icon" width="64" height="64">
          Check new Chrome Extension for ur2.pl. Click here!
        </a>
        <form action="" method="post">
          <input id="longUrl" type="url" name="url" placeholder="Paste your URL here (with http://)" autofocus>
          <input type="submit" value="Go">
        </form>
      </div>
      <p class="url info-box" data-url-container></p>
      <p class="error info-box" data-error-container></p>
      <a href="/" title="Click shift+/ (?) to see help" class="info name">UR2</span>
      <a href="https://twitter.com/share?url=http://ur2.pl&amp;text=Check+the+ur2+-+short+urls+has+never+been+so+easy" title="Share on twitter" class="info twitter" target="_blank"></a>
    </div>
    <!--[if lt IE 9]>
      <script src="/media/js/html5shiv.js"></script>
    <![endif]-->
    <script src="/media/js/jquery-1.9.1.min.js"></script>
    <script src="/media/js/scripts.js?rev=<?php echo $revision;?>"></script>
  </body>
</html>