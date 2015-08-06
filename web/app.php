<?php

require '../vendor/autoload.php';

define('APP_ROOT_DIR', __DIR__.'/../');

$app = new \Slim\Slim(array(
    'templates.path' => APP_ROOT_DIR.'app/views/'
));

$app->get('/', function() use ($app) {
    $app->render('layout.php', array());
});

$app->post('/api/v1/send/:apiKey', function($apiKey) use ($app) {

    $userResolver = new \Kielo\UserResolver();
    $user = $userResolver->getUserByApiKey($apiKey);

    $mailer = \Kielo\MailerFactory::createFromUserConfiguration($user->getDefaultServerConfiguration());

    $message = new \Kielo\Message(
        $app->request->get('s'),
        $app->request->get('m'),
        $app->request->get('to'),
        $user
    );

    $sender = new \Kielo\MailSender($mailer, $message);

    \Kielo\Response\Response::json(
        $app->response,
        array('success'=>$sender->send())
    );

});

$app->run();