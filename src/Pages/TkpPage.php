<?php


namespace App\Pages;


use App\Controllers\ClientController;
use App\Controllers\SearchController;
use App\Controllers\TkpController;
use App\Controllers\TkpGenerator;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class TkpPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private TkpController $tkpController;
    private SearchController $searchController;

    private ClientController $clientController;

    private TkpGenerator $tkpGenerator;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        TkpController $tkpController,
        SearchController $searchController,
        ClientController $clientController,
        TkpGenerator $tkpGenerator
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->tkpController = $tkpController;
        $this->searchController = $searchController;
        $this->clientController = $clientController;
        $this->tkpGenerator = $tkpGenerator;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $params = $request->getQueryParams();
        $activeCategory = 1;
        if(isset($params['category'])) {
            $activeCategory = $params['category'];
        }

        $tkpCategories = $this->tkpController->getTkpCategories($activeCategory);

        $tkpCategoriesParams = $this->tkpController->getTkpCategoriesParams($activeCategory);
        $prevLink = '/tkp?category='.$activeCategory;
        $lastStep = false;


        if(isset($params['tkp_params']) && isset($params['tkp_values'])) {

            $tkpCategoriesParams = $this->tkpController->getNextParams($params['tkp_params'], $params['tkp_values'], $activeCategory);
            if(count($tkpCategoriesParams) == 1) {
                $lastStep = true;
            }
        }

        $tkpCategoriesParams = array_shift($tkpCategoriesParams);

        $data = $this->twig->fetch('tkp/tkp-construct.twig', [
            'title' => 'Конструктор ТКП',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'categories' => $tkpCategories,
            'category_params' => $tkpCategoriesParams,
            'prevLink' => $prevLink,
            'lastStep' => $lastStep
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }


    public function getTkpResults(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $params = $request->getQueryParams();


        $tkpList = [];
        if(isset($params['tkp_params']) && isset($params['tkp_values'])) {
            $tkpList = $this->tkpController->filteredTkpByChars($params['tkp_params'], $params['tkp_values'], $params['category']);
        }

        $data = $this->twig->fetch('tkp/tkp-results.twig', [
            'title' => 'Конструктор ТКП',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'tkp_list' => $tkpList
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }


    public function getTkp(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $tkpId = $args['id'];
        $tkpData = $this->tkpController->getTkpAndMaterials($tkpId);
        $userClients = $this->clientController->getClients($userId);

        $data = $this->twig->fetch('tkp/tkp-create.twig', [
            'title' => 'Конструктор ТКП',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'tkp_data' => $tkpData,
            'user_clients' => $userClients
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }


    public function search(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        $data = '';
        if(isset($params['query'])) {
            $data = $this->searchController->searchTkp($params['query']);
        }
        return new Response(
            200,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function generateTkp(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        $tkp = $this->tkpGenerator->createTkp(
            $params['tkp_id'],
            $params['customer_id'],
            $params['installation_place'],
            $params['expired_date']
        );
        $data = json_encode($tkp, JSON_UNESCAPED_UNICODE);
        return new Response(
            200,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream($data)
        );
    }
}