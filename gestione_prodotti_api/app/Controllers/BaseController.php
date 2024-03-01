<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Classe BaseController
 *
 * BaseController fornisce un luogo conveniente per caricare componenti
 * e eseguire funzioni necessarie per tutti i tuoi controller.
 * Estendi questa classe in qualsiasi nuovo controller:
 *     class Home extends BaseController
 *
 * Per sicurezza, assicurati di dichiarare tutti i nuovi metodi come protetti o privati.
 */
abstract class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * Istanza dell'oggetto Request principale.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Un array di helper da caricare automaticamente all'istanziazione della classe.
     * Questi helper saranno disponibili a tutti gli altri controller che estendono BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Non modificare questa riga
        parent::initController($request, $response, $logger);

        // Precarica eventuali modelli, librerie, ecc. qui.

        // Esempio: $this->session = \Config\Services::session();
    }
}
