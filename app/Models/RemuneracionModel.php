<?php

namespace App\Models;

use CodeIgniter\Model;

class RemuneracionModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'nivel_remunerativo';
    protected $primaryKey = 'id_remuneracion ';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_remuneracion', 'nivel', 'fecha_registro', 'estado_nivel'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_At';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function mdListarRemuneraciones()
    {
        return $this->where('estado_nivel', 1)
                    ->orWhere('estado_nivel', 2)
                    ->get()
                    ->getResultArray();
    }

    public function getAllActive()
    {
        return $this->where('estado_nivel', 1)
                    ->get()
                    ->getResultArray();
    }
}
