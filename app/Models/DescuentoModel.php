<?php

namespace App\Models;

use CodeIgniter\Model;

class DescuentoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'descuentos';
    protected $primaryKey       = 'id_descuento';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_tipo_descuento', 'nombre_descuento', 'cantidad_descuento', 'estado_descuento'];

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

    public function mdListarDescuentos()
    {
        return $this->join('tipo_descuento td', 'td.id_tipo_descuento = descuentos.id_tipo_descuento')
                    ->where('descuentos.estado_descuento', 1)
                    ->Orwhere('descuentos.estado_descuento', 2)
                    ->get()
                    ->getResultArray();
    }

    public function getAllActive()
    {
        return $this->where('estado_descuento', 1)
                    ->get()
                    ->getResultArray();
    }
}
