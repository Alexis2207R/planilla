<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanillaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'planilla';
    protected $primaryKey       = 'id_planilla';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_tipo_planilla', 'id_year', 'numero_planilla', 'total_ingreso',
                                   'total_egreso', 'total_neto', 'fecha_creacion_planilla', 'estado_planilla'];

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

    public function mdListarPlanillas()
    {
        return $this->join('tipo_planilla tp', 'tp.id_tipo_planilla = planilla.id_tipo_planilla')
                    ->join('ano a',            'a.id_year = planilla.id_year')
                    ->where('planilla.estado_planilla', 1)
                    ->Orwhere('planilla.estado_planilla', 2)
                    ->get()
                    ->getResultArray();
    }

    public function mdVerPlanilla($id)
    {
        $planilla = $this->join('tipo_planilla tp', 'tp.id_tipo_planilla = planilla.id_tipo_planilla')
                         ->join('ano a',            'a.id_year = planilla.id_year')
                         ->where('planilla.id_planilla', $id)
                         ->get()
                         ->getResultArray();
        $planilla = $planilla[0];

        $modPlanillaBonificacion = new PlanillaBonificacionModel();
        $modPlanillaDescuento    = new PlanillaDescuentoModel();

        $bonificaciones = $modPlanillaBonificacion->mdVerDePlanilla($id);
        $descuentos     =  $modPlanillaDescuento->mdVerDePlanilla($id);

        $data = [
            'planilla'       => $planilla,
            'bonificaciones' => $bonificaciones,
            'descuentos'     => $descuentos
        ];

        return $data;
    }

    public function getAllActive()
    {
        return $this->where('estado_planilla', 1)
                    ->get()
                    ->getResultArray();
    }
}
