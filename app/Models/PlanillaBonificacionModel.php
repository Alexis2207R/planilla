<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanillaBonificacionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'planilla_bonificacion';
    protected $primaryKey       = 'id_planilla_bonificacion';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_planilla', 'id_bonificacion', 'estado_planilla_bonificacion'];

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

    public function mdVerDePago($id)
    {
        return $this->join('bonificacion b', 'b.id_bonificacion = pago_bonificacion.id_bonificacion')
                    ->where('pago_bonificacion.id_pago', $id)
                    ->where('pago_bonificacion.estado_pago_bonificacion', 1)
                    ->get()
                    ->getResultArray();
    }

    public function banFromPago($id)
    {
        return $this->where('id_pago', $id)
                    ->set(['estado_pago_bonificacion' => 0])
                    ->update();
    }
}
