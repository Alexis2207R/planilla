<?php
namespace App\Models;
use CodeIgniter\Model;

class PersonalModel extends Model{
	
  protected $table = 'personal';
  protected $primaryKey = 'id_personal';
  protected $returnType = 'array';
  protected $allowedFields = ['nombre_personal', 'paterno_personal', 'materno_personal', 'dni_personal', 'sexo_personal',
                              'nivel_remuneracion', 'condicion_laboral','ubicacion_dpt', 'ubicacion_prov', 'ubicacion_dist',
                              'direccion_personal', 'sueldo_personal', 'incentivo_personal', 'costo_dia', 'costo_hora', 'costo_minuto',
                              'fecha_registro', 'fecha_actualizacion', 'estado_personal'];

  public function mdlListarPersonal()
  {

  }


}
