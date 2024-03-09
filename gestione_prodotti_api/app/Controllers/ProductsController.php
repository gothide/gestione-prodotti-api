<?php



namespace App\Controllers;



use App\Models\ProductsModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use OpenApi\Annotations as OA;

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
class ProductsController extends Controller
{
    use ResponseTrait;

    /**
     * @OA\Get(
     *      path="/prodotti",
     *      tags={"Prodotti"},
     *      summary="Elenco dei prodotti",
     *      security={{ "basicAuth":{"admin:admin"} }},
     *      @OA\Response(response=200, description="Elenco dei prodotti"),
     *      @OA\Response(response=404, description="Nessun prodotto trovato")
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
     * @OA\Get(
     *      path="/prodotti/{id}",
     *      tags={"Prodotti"},
     *      summary="Mostra un singolo prodotto",
     *      security={{ "basicAuth":{"admin:admin"} }},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     * @OA\Schema(
     *      type="integer"
     *      )
     * ),
     * @OA\Response(response=200, description="Mostra un singolo prodotto"),
     * @OA\Response(response=404, description="Prodotto non trovato")
     * )
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
     * @OA\Post(
     *      path="/prodotti",
     *      tags={"Prodotti"},
     *      summary="Crea un nuovo prodotto",
     *      security={{ "basicAuth":{"admin:admin"} }},
     * @OA\RequestBody(
     *      required=true,
     * @OA\MediaType(
     *      mediaType="application/json",
     * @OA\Schema(
     *     @OA\Property(
     *          property="nome",
     *          type="string"
     *          ),
     * 
     *      @OA\Property(
     *          property="prezzo",
     *          type="number"
     *          ),
     * 
     *      @OA\Property(
     *          property="quantità_in_magazzino",
     *          type="integer"
     *          )
     *      )
     *  )
     * ),
     * @OA\Response(response=201, description="Prodotto creato con successo"),
     * @OA\Response(response=400, description="Errore di validazione")
     * )
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
     * @OA\Get(
     *      path="/prodotti/{id}/modifica",
     *      tags={"Prodotti"},
     *      summary="Mostra il modulo di modifica per un prodotto esistente",
     *      security={{ "basicAuth":{"admin:admin"} }},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     * @OA\Schema(
     *      type="integer"
     *      )
     * ),
     * @OA\Response(response=200, description="Mostra il modulo di modifica per un prodotto esistente"),
     * @OA\Response(response=404, description="Prodotto non trovato")
     * )
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
     * @OA\Put(
     *      path="/prodotti/{id}",
     *      tags={"Prodotti"},
     *      summary="Aggiorna un prodotto esistente",
     *      security={{ "basicAuth":{"admin:admin"} }},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     * @OA\Schema(
     *      type="integer"
     *      )
     * ),
     * @OA\RequestBody(
     *      required=true,
     * @OA\MediaType(
     *      mediaType="application/json",
     * 
     * @OA\Schema(
     *      @OA\Property(
     *          property="nome",
     *          type="string"
     *          ),
     *  
     *      @OA\Property(
     *          property="prezzo",
     *          type="number"
     *          ),
     *  
     *      @OA\Property(
     *          property="quantità_in_magazzino",
     *          type="integer"
     *          )
     *      )
     *  )
     * ),
     * @OA\Response(response=200, description="Prodotto aggiornato con successo"),
     * @OA\Response(response=400, description="Errore di validazione")
     * )
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
     * @OA\Delete(
     *      path="/prodotti/{id}",
     *      tags={"Prodotti"},
     *      summary="Elimina un prodotto esistente",
     *      security={{ "basicAuth":{"admin:admin"} }},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     * @OA\Schema(
     *      type="integer"
     *      )
     * ),
     * @OA\Response(response=200, description="Prodotto eliminato con successo"),
     * @OA\Response(response=404, description="Prodotto non trovato")
     * )
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
