<?php
namespace App\classes\Traits;


trait Message{
    
    public function Message(string $status, string $msg, string $location = null)
    {
        if($location === null){
            $response = (['status' => $status, 'msg' => $msg]);
            return $response;
        }
        $response = (['status' => $status, 'msg' => $msg, 'location' => $location]);
        return $response;
        // return $this->respondWithData($response)->withStatus(200);
    }
}