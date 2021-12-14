<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__.'/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function(Request $request, Response $response, array $args) {
    $renderer = new PhpRenderer(__DIR__.'/../app/views/');

    return $renderer->render($response, "layout.php", $args);
});

$app->post('/api/v1/send/{apiKey}', function(Request $request, Response $response, array $args) {

    $userResolver = new \Kielo\UserResolver();
    $user = $userResolver->getUserByApiKey($args['apiKey']);

    $mailer = \Kielo\MailerFactory::createFromUserConfiguration($user->getDefaultServerConfiguration());

    $message = new \Kielo\Message(
        $request->getQueryParams()['s'],
        $request->getQueryParams()['m'],
        $request->getQueryParams()['to'],
        $user
    );

    $sender = new \Kielo\MailSender($mailer, $message);

    $body = json_encode(['success'=>$sender->send()]);

    $response->getBody()->write($body);
    
    return $response->withHeader('Content-Type', 'application/json');

});

$app->run();