<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'regimen_pensional';
    protected $primaryKey       = 'id_regimen';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_regimen', 'creacion_regimen', 'estado_regimen'];

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
        return $this->where('estado_regimen', 1)
            ->get()
            ->getResultArray();
    }

    public function mdListarRegimenes()
    {
        return $this->where('estado_regimen', 1)
            ->orWhere('estado_regimen', 2)
            ->get()
            ->getResultArray();
    }

}
