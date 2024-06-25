<?php
declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;

use App\Application\Actions\LoginAction\LogarAction;
use App\Application\Actions\Listagem\ListarTodosAction;
use App\Application\Actions\Listagem\ListOneUserAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Editar\EditarCadastroAction;
use App\Application\Actions\Cadastro\CadastrarUserAction;
use App\Application\Actions\LoginAction\SairSessaoAction;
use App\Application\Actions\Cadastro\CadastrarNiverAction;
use App\Application\Actions\Excluir\ExcluirCadastroAction;
use App\Application\Actions\Listagem\ListarAniversariosAction;

return function (App $app) {
    // $app->options('/{routes:.*}', function (Request $request, Response $response) {
    //     // CORS Pre-Flight OPTIONS Request Handler
    //     return $response;
    // });

    $app->get('/', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html', []);});
    $app->get('/home', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.html', []);}); //home exibira somente aniversariantes do mes/?semana (edição e cadastro somente adms)
    $app->get('/exibir_todos', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'exibir_todos.html', []);}); //exibira todos os aniversariantes em datatables 


    $app->post("/login",LogarAction::class );
    $app->post("/sair",SairSessaoAction::class);
    $app->post("/cadastro_usuarios",CadastrarUserAction::class);
    $app->post("/cadastro_aniversarios",CadastrarNiverAction::class);

    $app->get("/listar_um",ListOneUserAction::class);
    $app->get("/listar_mes",ListarAniversariosAction::class);
    $app->get("/listar_todos",ListarTodosAction::class);

    $app->post("/editar_cadastro",EditarCadastroAction::class);
    $app->post("/excluir_cadastro",ExcluirCadastroAction::class);


   
};
