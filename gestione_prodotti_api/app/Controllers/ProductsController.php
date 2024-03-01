<?php

/**
 * @OA\Info(
 *      title="gestione_prodotti_api",
 *      version="1.0.0",
 *      description="Questa è un'applicazione web CRUD per la gestione di prodotti tramite API.",
 *      @OA\Contact(
 *          email="campus.davide.dev@gmail.com"
 *      ),
 *      @OA\License(
 *         name="Apache 2.0",
 *        url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

namespace App\Controllers;

use App\Models\ProductsModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use OpenApi\Annotations as OA;


class ProductsController extends Controller
{
    use ResponseTrait;

    /**
     * @OA\Get(
     *     path="/prodotti",
     *     tags={"Prodotti"},
     *     summary="Elenco dei prodotti",
     *     @OA\Response(response=200, description="Elenco dei prodotti"),
     * )
     */
    public function index()
    {
        // Recupera tutti i prodotti dal database
        $model = new ProductsModel();
        $prodotti = $model->findAll();

        // Ritorna la vista con l'elenco dei prodotti
        return view('home/index', ['prodotti' => $prodotti]);
    }

    /**
     * Mostra un singolo prodotto
     *
     * @param int $id ID del prodotto
     * @return string JSON rappresentante il prodotto
     */
    public function show($id)
    {
        // Trova il prodotto dal database utilizzando l'ID fornito
        $model = new ProductsModel();
        $prodotto = $model->find($id);

        // Se il prodotto non esiste, restituisce un messaggio di errore
        if ($prodotto === null) {
            return "Prodotto non trovato.";
        }

        // Ritorna il prodotto sotto forma di JSON
        return json_encode($prodotto);
    }

    /**
     * Crea un nuovo prodotto
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function create()
    {
        // Ottieni i dati inviati dalla richiesta POST
        $data = $this->request->getVar();

        // Validazione dei dati
        if (empty($data['nome']) || empty($data['prezzo']) || empty($data['quantità_in_magazzino'])) {
            return redirect()->to('/')->withInput()->with('error', 'Tutti i campi sono obbligatori.');
        }

        // Crea un'istanza del modello ProductsModel
        $model = new ProductsModel();

        // Inserisci il nuovo prodotto nel database
        $result = $model->insert($data);

        // Se l'inserimento ha avuto successo, reindirizza alla pagina principale con un messaggio di successo
        if ($result === true) {
            return redirect()->to('/')->with('success', 'Prodotto creato con successo.');
        } else {
            // Se l'inserimento ha fallito, reindirizza alla pagina principale con un messaggio di errore
            return redirect()->to('/')->withInput()->with('error', 'Impossibile creare il prodotto.');
        }
    }

    /**
     * Mostra il modulo di modifica per un prodotto esistente
     *
     * @param int $id ID del prodotto
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function edit($id)
    {
        // Trova il prodotto dal database utilizzando l'ID fornito
        $model = new ProductsModel();
        $prodotto = $model->find($id);

        // Se il prodotto non esiste, restituisce un messaggio di errore
        if ($prodotto === null) {
            return "Prodotto non trovato.";
        }

        // Ritorna la vista di modifica con i dati del prodotto
        return view('home/edit', ['prodotto' => $prodotto]);
    }

    /**
     * Aggiorna un prodotto esistente nel database
     *
     * @param int $id ID del prodotto
     * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\Response
     */
    public function update($id)
    {
        // Ottieni i dati inviati dalla richiesta POST
        $data = $this->request->getVar();

        // Validazione dei dati
        if (empty($data['nome']) || empty($data['prezzo']) || empty($data['quantità_in_magazzino'])) {
            return $this->fail('Tutti i campi sono obbligatori.');
        }

        // Crea un'istanza del modello ProductsModel
        $model = new ProductsModel();

        // Aggiorna il prodotto nel database
        $result = $model->update($id, $data);

        // Se l'aggiornamento ha avuto successo, reindirizza alla pagina principale con un messaggio di successo
        if ($result === true) {
            session()->setFlashdata('success', 'Prodotto aggiornato con successo.');
            return redirect()->to('/');
        } else {
            // Se l'aggiornamento ha fallito, restituisci un messaggio di errore
            return $this->fail('Impossibile aggiornare il prodotto.');
        }
    }

    /**
     * Elimina un prodotto esistente dal database
     *
     * @param int $id ID del prodotto
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        // Crea un'istanza del modello ProductsModel
        $model = new ProductsModel();

        // Elimina il prodotto dal database
        $result = $model->delete($id);

        // Se l'eliminazione ha avuto successo, reindirizza alla pagina principale con un messaggio di successo
        if ($result === true) {
            session()->setFlashdata('success', 'Prodotto eliminato con successo.');
            return redirect()->to('/');
        } else {
            // Se l'eliminazione ha fallito, reindirizza alla pagina principale con un messaggio di errore
            return redirect()->to('/')->with('error', 'Impossibile eliminare il prodotto.');
        }
    }
}
