<?php

namespace App\Models;

use CodeIgniter\Model;

class CargoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cargo';
    protected $primaryKey       = 'id_cargo';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_cargo', 'estado_cargo'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

  public function mdListarCargos()
  {
    return $this->where('estado_cargo', 1)
                ->orWhere('estado_cargo', 2)
                ->get()
                ->getResultArray();
  }

}
