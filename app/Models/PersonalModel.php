<?php
namespace App\Models;
use CodeIgniter\Model;

class PersonalModel extends Model
{
  protected $table = 'personal';
  protected $primaryKey = 'id_personal';
  protected $returnType = 'array';
  protected $allowedFields = ['nombre_personal', 'apellido_personal', 'dni_personal', 'sexo_personal',
                              'ubicacion_dpt', 'ubicacion_prov', 'ubicacion_dist', 'direccion_personal', 'nro_cuenta','id_regimen', 'id_cargo',
                              'id_remuneracion', 'id_condicion', 'dias_horas', 'fecha_registro', 'fecha_actualizacion', 'estado_personal'];

  public function mdListarPersonales()
  {
    return $this->join('regimen_pensional tp',   'tp.id_regimen = personal.id_regimen')
                ->join('cargo a',                'a.id_cargo = personal.id_cargo')
                ->join('nivel_remunerativo nr',  'nr.id_remuneracion = personal.id_remuneracion')
                ->join('condicion_laboral cl',   'cl.id_condicion = personal.id_condicion')
                ->where('personal.estado_personal', 1)
                ->Orwhere('personal.estado_personal', 2)
                ->get()
                ->getResultArray();
  }

  public function mdListarPersonal($id)
  {
    return $this->join('regimen_pensional tp',   'tp.id_regimen = personal.id_regimen')
                ->join('cargo a',                'a.id_cargo = personal.id_cargo')
                ->join('nivel_remunerativo nr',  'nr.id_remuneracion = personal.id_remuneracion')
                ->join('condicion_laboral cl',   'cl.id_condicion = personal.id_condicion')
                ->where('personal.id_personal', $id)
                ->get()
                ->getResultArray();
  }


  public function getAllActive()
  {
    return $this->where('estado_personal', 1)
                ->get()
                ->getResultArray();
  }
}
