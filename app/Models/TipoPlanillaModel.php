<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoPlanillaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tipo_planilla';
    protected $primaryKey       = 'id_tipo_planilla';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_tipo_planilla', 'estado_tipo_planilla'];

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

    public function mdListarTipoPlanillas()
    {
        return $this->where('estado_tipo_planilla', 1)
                    ->orWhere('estado_tipo_planilla', 2)
                    ->get()
                    ->getResultArray();
    }

    public function getAllActive()
    {
        return $this->where('estado_tipo_planilla', 1)
                    ->get()
                    ->getResultArray();
    }

}
