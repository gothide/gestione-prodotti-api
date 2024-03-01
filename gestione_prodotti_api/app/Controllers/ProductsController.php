<?php 

namespace App\Controllers;

use App\Models\ProductsModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class ProductsController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $model = new ProductsModel();

        $prodotti_json = json_encode($model->findAll());

        $data['prodotti'] = json_decode($prodotti_json, true);

        return view('home/index', $data);
    }

    public function show($id)
    {
        $model = new ProductsModel();

        $prodotto = $model->find($id);

        if ($prodotto === null) {
            return "Prodotto non trovato.";
        }

        return json_encode($prodotto);
    }

    public function create()
    {
        $data = [
            'nome' => $this->request->getPost('nome'),
            'prezzo' => $this->request->getPost('prezzo'),
            'quantità_in_magazzino' => $this->request->getPost('quantita')
        ];

        $model = new ProductsModel();

        $result = $model->insert($data);

        if ($result) {
            // Operazione di aggiunta riuscita, reindirizza alla pagina index
            return redirect()->to('/');
        } else {
            // Operazione di aggiunta fallita, mostra un messaggio di errore
            return "Impossibile aggiungere il prodotto.";
        }
    }

    public function update($id)
    {
        // Ottieni i dati inviati dalla richiesta PUT
        $data = $this->request->getVar();

        // Validazione dei dati - puoi aggiungere la tua logica di validazione qui

        // Creiamo un'istanza del modello
        $model = new ProductsModel();

        // Aggiorniamo il prodotto nel database
        $result = $model->update($id, $data);

        // Verifica se l'aggiornamento è riuscito
        if ($result === false) {
            return $this->fail('Impossibile aggiornare il prodotto.');
        }

        // Ritorna un messaggio di successo
        return $this->respondUpdated($data, 'Prodotto aggiornato con successo.');
    }

    public function delete($id)
    {
        // Creiamo un'istanza del modello
        $model = new ProductsModel();

        // Eliminiamo il prodotto dal database
        $result = $model->delete($id);

        // Verifica se l'eliminazione è riuscita
        if ($result === false) {
            return $this->fail('Impossibile eliminare il prodotto.');
        }

        // Ritorna un messaggio di successo
        return $this->respondDeleted('Prodotto eliminato con successo.');
    }
}
