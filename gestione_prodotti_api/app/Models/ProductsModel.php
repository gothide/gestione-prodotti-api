<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = 'Prodotti';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'prezzo', 'quantità_in_magazzino'];
}
