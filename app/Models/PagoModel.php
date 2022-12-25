<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pagos';
    protected $primaryKey       = 'id_pago';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_personal', 'id_planilla', 'id_mes', 'total_ingreso',
                                   'total_egreso', 'total_neto', 'fecha_creacion', 'estado_pago'];

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

    public function mdListarPagos()
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.estado_pago', 1)
                    ->Orwhere('pagos.estado_pago', 2)
                    ->get()
                    ->getResultArray();
    }

    public function getAllActive()
    {
        return $this->where('estado_pago', 1)
                    ->get()
                    ->getResultArray();
    }

    // Todos los anios
    public function mdListarDePersona($idPersonal)
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.estado_pago', 1)
                    ->where('a.id_personal', $idPersonal)
                    ->get()
                    ->getResultArray();
    }

    public function mdVerPago($id)
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.id_pago', $id)
                    ->where('pagos.estado_pago', 1)
                    ->Orwhere('pagos.estado_pago', 2)
                    ->get()
                    ->getResultArray();
    }

    public function mdListarDePersonaPorAnios($idPersonal, $idYears)
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.estado_pago', 1)
                    ->where('a.id_personal', $idPersonal)
                    ->whereIn('b.id_year', $idYears)
                    ->get()
                    ->getResultArray();
    }

    public function mdListarDePersonaPorTodo($idPersonal)
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.estado_pago', 1)
                    ->where('a.id_personal', $idPersonal)
                    ->get()
                    ->getResultArray();
    }


    public function mdListarDePersonaPorAnio($idPersonal, $idYear)
    {
        return $this->join('personal a', 'a.id_personal = pagos.id_personal')
                    ->join('planilla b', 'b.id_planilla = pagos.id_planilla')
                    ->join('mes d',      'd.id_mes = pagos.id_mes')
                    ->join('ano  e',     'e.id_year = b.id_year')
                    ->where('pagos.estado_pago', 1)
                    ->where('a.id_personal', $idPersonal)
                    ->where('b.id_year', $idYear)
                    ->get()
                    ->getResultArray();
    }

}
