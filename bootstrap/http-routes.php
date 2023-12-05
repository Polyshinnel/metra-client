<?php

use App\Middleware\BasicAuthMiddleware;
use App\Pages\AuthPage;
use App\Pages\ForgottenPage;
use App\Pages\IndexPage;
use App\Pages\RegisterPage;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/auth', [AuthPage::class, 'get']);
    $app->post('/auth', [AuthPage::class, 'authorize']);
    $app->get('/err-entry', [AuthPage::class, 'error']);

    $app->get('/register', [RegisterPage::class, 'get']);
    $app->post('/register', [RegisterPage::class, 'registration']);
    $app->get('/success-register', [RegisterPage::class, 'success']);

    $app->get('/forgotten-password', [ForgottenPage::class, 'get']);
    $app->get('/forgotten-password-change', [ForgottenPage::class, 'change']);
    $app->get('/err-restore', [ForgottenPage::class, 'error']);
    $app->get('/success-restore-request', [ForgottenPage::class, 'successRequest']);
    $app->get('/success-restore', [ForgottenPage::class, 'success']);
    $app->post('/restore-request', [ForgottenPage::class, 'request']);
    $app->post('/restore-password', [ForgottenPage::class, 'changePassword']);



    $app->group('/',function (RouteCollectorProxy $group) {
        $group->get('',[IndexPage::class,'get']);
    })->add(BasicAuthMiddleware::class);;
};