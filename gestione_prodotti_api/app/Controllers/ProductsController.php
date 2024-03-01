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
        $data = $this->request->getVar();

        if (empty($data['nome']) || empty($data['prezzo']) || empty($data['quantità_in_magazzino'])) {
            return redirect()->to('/')->withInput()->with('error', 'Tutti i campi sono obbligatori.');
        }

        $model = new ProductsModel();

        $result = $model->insert($data);

        if ($result === false) {
            return redirect()->to('/')->withInput()->with('error', 'Impossibile creare il prodotto.');
        }

        return redirect()->to('/')->with('success', 'Prodotto creato con successo.');
    }

    public function edit($id)
    {
        $model = new ProductsModel();

        $prodotto = $model->find($id);

        if ($prodotto === null) {
            return "Prodotto non trovato.";
        }

        return view('home/edit', ['prodotto' => $prodotto]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if (empty($data['nome']) || empty($data['prezzo']) || empty($data['quantità_in_magazzino'])) {
            return $this->fail('Tutti i campi sono obbligatori.');
        }

        $model = new ProductsModel();

        $result = $model->update($id, $data);

        if ($result === false) {
            return $this->fail('Impossibile aggiornare il prodotto.');
        }

        session()->setFlashdata('success', 'Prodotto aggiornato con successo.');

        return redirect()->to('/');
    }

    public function delete($id)
    {
        $model = new ProductsModel();

        $result = $model->delete($id);

        if (!$result) {
            return redirect()->to('/')->with('error', 'Impossibile eliminare il prodotto.');
        }

        session()->setFlashdata('success', 'Prodotto eliminato con successo.');

        return redirect()->to('/');
    }

}
