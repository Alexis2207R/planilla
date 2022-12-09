<?php

namespace App\Models;

use CodeIgniter\Model;

class BonificacionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bonificacion';
    protected $primaryKey       = 'id_bonificacion';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_tipo_bonificacion', 'nombre_bonificacion', 'cantidad_bonificacion', 'estado_bonificacion'];

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

    public function mdListarBonificaciones()
    {
        return $this->join('tipo_bonificacion tp', 'tp.id_tipo_bonificacion = bonificacion.id_tipo_bonificacion')
                    ->where('bonificacion.estado_bonificacion', 1)
                    ->Orwhere('bonificacion.estado_bonificacion', 2)
                    ->get()
                    ->getResultArray();
    }
}
