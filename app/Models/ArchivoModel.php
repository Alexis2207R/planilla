<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'archivos';
    protected $primaryKey       = 'id_archivo';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_archivo', 'ruta_archivo', 'fecha_archivo', 'creacion_archivo', 'estado_archivo'];

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

    public function mdListarArchivos()
    {
        return $this->where('estado_archivo', 1)
                    ->orWhere('estado_archivo', 2)
                    ->get()
                    ->getResultArray();
    }


}
