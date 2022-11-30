<?php
namespace App\Models;
use CodeIgniter\Model;

class TipobonificacionModel extends Model{
	
  protected $table = 'tipo_bonificacion';
  protected $primaryKey = 'id_tipo_bonificacion';
  protected $returnType = 'array';
  protected $allowedFields = ['nombre_tipo_bonificacion','estado_tipo_bonificacion'];

  public function getTipobonificaciones(){
    return $this -> db  -> table('tipo_bonificacion tb')
                        -> where('tb.estado_tipo_bonificacion', 1)
                        -> get()
                        -> getResultArray();
  }

}
