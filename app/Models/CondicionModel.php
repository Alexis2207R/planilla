<?php
namespace App\Models;
use CodeIgniter\Model;

class CondicionModel extends Model{
	
  protected $table = 'condicion_laboral';
  protected $primaryKey = 'id_condicion';
  protected $returnType = 'array';
  protected $allowedFields = ['condicion','creacion_condicion','estado_condicion'];

  public function getCondicion(){
    return $this -> db  -> table('condicion_laboral cl')
                        -> where('cl.estado_condicion', 1)
                        -> get()
                        -> getResultArray();
  }

}
