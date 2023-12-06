<?php

use App\Middleware\BasicAuthMiddleware;
use App\Pages\AcademyPage;
use App\Pages\AddMaterialsPage;
use App\Pages\AuthPage;
use App\Pages\CatalogPage;
use App\Pages\ForgottenPage;
use App\Pages\IndexPage;
use App\Pages\NewsPage;
use App\Pages\ProfilePage;
use App\Pages\RegisterPage;
use App\Pages\TkpPage;
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

    $app->get('/exit',[IndexPage::class,'exit']);

    $app->group('/',function (RouteCollectorProxy $group) {
        $group->get('',[IndexPage::class,'get']);
        $group->get('news',[NewsPage::class,'get']);
        $group->get('catalog',[CatalogPage::class,'get']);
        $group->get('profile',[ProfilePage::class,'get']);
        $group->get('notification',[ProfilePage::class,'notification']);
        $group->get('clients',[ProfilePage::class,'clients']);

    })->add(BasicAuthMiddleware::class);;

    $app->group('/academy',function (RouteCollectorProxy $group) {
        $group->get('',[AcademyPage::class,'get']);
    })->add(BasicAuthMiddleware::class);;

    $app->group('/add-materials',function (RouteCollectorProxy $group) {
        $group->get('',[AddMaterialsPage::class,'get']);
    })->add(BasicAuthMiddleware::class);;

    $app->group('/tkp-construct',function (RouteCollectorProxy $group) {
        $group->get('',[TkpPage::class,'get']);
    })->add(BasicAuthMiddleware::class);;
};