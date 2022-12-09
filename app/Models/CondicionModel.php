<?php
namespace App\Models;
use CodeIgniter\Model;

class CondicionModel extends Model
{
  protected $table = 'condicion_laboral';
  protected $primaryKey = 'id_condicion';
  protected $returnType = 'array';
  protected $allowedFields = ['condicion','creacion_condicion','estado_condicion'];

  public function mdListarCondiciones()
  {
    return $this->where('estado_condicion', 1)
                ->orWhere('estado_condicion', 2)
                ->get()
                ->getResultArray();
  }

}
