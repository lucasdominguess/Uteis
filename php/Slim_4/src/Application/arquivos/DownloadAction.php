<?php
namespace App\Application\Actions\User\controlers\arquivos;




use Slim\Psr7\Stream;

use App\Domain\User\User;
use App\Application\Actions\Action;

use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;



class DownloadAction extends Action
{
    public function action(): Response
    {   
        $filename = $_GET['id'] ?? '';

        if (empty($filename)) { 
            throw new HttpBadRequestException($this->request, 'Nome do arquivo inválido');
        }

        $userFolder = 'ID_0'.$_SESSION[User::USER_ID]."_".strtoupper($_SESSION[User::USER_NAME]) ;
        $filepath = realpath(__DIR__ . "/../../../../files/arquivos/$userFolder/$filename");

        if ($filepath === false || !file_exists($filepath)) {
            throw new HttpNotFoundException($this->request, "Arquivo não encontrado");
        }

        $fileStream = fopen($filepath, 'r');
        if ($fileStream === false) {
            throw new HttpNotFoundException($this->request, "Não foi possível abrir o arquivo");
        }

        $stream = new Stream($fileStream);
        $fileName = basename($filename);
        $mimeType = mime_content_type($filepath);
        $fileSize = filesize($filepath);
        $arq = rawurlencode($fileName);
        $response = $this->response 
            ->withBody($stream)
            ->withHeader('Content-Disposition', 'attachment; filename='.$arq)
            ->withHeader('Content-Type', $mimeType)
            ->withHeader('Content-Length', (string)$fileSize)
            ->withHeader('Cache-Control', 'no-cache, must-revalidate')
            ->withHeader('Pragma', 'no-cache')
            ->withStatus(200);

   
        // $response->getBody()->close();

        return $response;
    }
}


