<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use OpenApi\Annotations as OA;

class Home extends BaseController
{
    use ResponseTrait;

    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Home"},
     *     summary="Homepage",
     *     @OA\Response(response=200, description="Homepage")
     * )
     *
     * @return string
     */
    
    public function home(): string
    {
        return view('home/index');
    }
}