<?php
require 'vendor/autoload.php';
require 'config/database.php';
require 'api.class.php';

$app = new \Slim\Slim(array(
  'templates.path' => './templates',
  'debug' => false
));

// Set this to your domain
$app->domain = 'yourdomain.com';

$app->container->singleton('api', function () use ($app, $dbConfig) {
  return new API($dbConfig, $app->domain);
});

function APIRequest() {
  $app = \Slim\Slim::getInstance();
  $app->view(new \JsonApiView());
  $app->add(new \JsonApiMiddleware());
  $response = $app->response();
  $response->header('Access-Control-Allow-Origin', '*');
}

/**
 * View pages
 */
$app->get('/', function () use ($app) {
  $app->render('shortener.php', array( 'revision' => 4 ));
});

$app->get('/:id+', function ($id) use ($app) {
  $result = $app->api->getLinkById($id);

  if ($result != null) {
    $app->render('redirect.php', array('urlShortened' => $result['urlShortened']));
  }
  else {
    $app->notFound();
  }
})->conditions(array('id' => '\d+'));

$app->get('/api', function () use ($app) {
  $app->render('docs.php');
});


/**
 * API Methods
 */
$app->group('/api', 'APIRequest', function () use ($app) {

  $app->get('/getLink/:id', function($id) use ($app) {

    $result = $app->api->getLinkById($id);

    if ($result != null) {
      $app->render(200, $result);
    }
    else {
      $app->render(404, array('error' => true, 'msg' => 'Link has not been found'));
    }
  })->conditions(array('id' => '\d+'));

  $app->put('/addLink', function() use ($app) {
    $putData = $app->request->put();

    if (array_key_exists('url', $putData)) {
      $url = $putData['url'];
      if ($app->api->validateUrl($url)) {

        if (strpos($url, $app->domain)) {
          $app->render(200, array('msg' => 'Huehue, nice try! <img src="http://'.$app->domain.'/media/gfx/smtlikethis.jpg" alt="">',
            'zonk' => true));
          return;
        }

        $existingUrl = $app->api->getLinkByUrl($url);

        if ($existingUrl) {
          $app->render(200, $existingUrl);
        }
        else {
          $lastInsertId = $app->api->addLink($url);

          $result = $app->api->getLinkById($lastInsertId);

          $app->render(201, $result);
        }
      }
      else {
        $app->render(400, array('error' => true, 'msg' => 'Provided url is not in a valid form'));
      }
    }
    else {
      $app->render(400, array('error' => true, 'msg' => 'Parameter `url` must be set'));
    }

  });
});

$app->run();