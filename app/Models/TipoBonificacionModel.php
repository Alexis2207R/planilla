<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoBonificacionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tipo_bonificacion';
    protected $primaryKey       = 'id_tipo_bonificacion';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_tipo_bonificacion', 'estado_tipo_bonificacion'];

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

  public function getAllActive()
  {
    return $this->where('estado_tipo_bonificacion', 1)
                ->orWhere('estado_tipo_bonificacion', 2)
                ->get()
                ->getResultArray();
  }

}
