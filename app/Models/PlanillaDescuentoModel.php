<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanillaDescuentoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'planilla_descuento';
    protected $primaryKey       = 'id_planilla_descuento';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_planilla', 'id_descuento', 'estado_planilla_descuento'];

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

    public function mdVerDePlanilla($id)
    {
        return $this->join('descuentos b', 'b.id_descuento = planilla_descuento.id_descuento')
                    ->where('planilla_descuento.id_planilla', $id)
                    ->where('planilla_descuento.estado_planilla_descuento', 1)
                    ->get()
                    ->getResultArray();
    }

    public function banFromPlanilla($id)
    {
        return $this->where('id_planilla', $id)
                    ->set(['estado_planilla_descuento' => 0])
                    ->update();
    }
}
