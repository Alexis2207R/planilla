<?php
namespace App\Models;
use CodeIgniter\Model;

class PersonalModel extends Model{
	
  protected $table = 'personal';
  protected $primaryKey = 'id_personal';
  protected $returnType = 'array';
  protected $allowedFields = ['nombre_personal', 'paterno_personal', 'materno_personal', 'dni_personal', 'sexo_personal', 'nivel_remuneracion', 'condicion_laboral','ubicacion_dpt', 'ubicacion_prov', 'ubicacion_dist', 'direccion_personal', 'sueldo_personal', 'incentivo_personal', 'costo_dia', 'costo_hora', 'costo_minuto', 'fecha_registro', 'fecha_actualizacion', 'estado_personal'];

  public function mdlListarPersonal(){
    // Aqui estaba prdListarPersonal()

  }

//   public function mdlModulos( $idperfil ){
//     return $this->db->table('permiso p')
//     ->join('modulo m', 'p.idmodulo=id_modulo')
//     ->join('perfil pe', 'p.idperfilpermiso = pe.id_perfil')
//     ->where([ 'm.estadomodulo' => 1, 'p.idperfilpermiso' => $idperfil ])
//     ->get()->getResultArray();
//   }

//   public function mdlListaModulos(){
//     return $this->db->table('modulo')
//     ->where( [ 'estadomodulo' => 1] )
//     ->get()->getResultArray();
//   }

//   public function mdlInsertPermisos( $datos ){
//     return $this->db->table('permiso')
//     ->insert( $datos );
//   }

//   public function mdlDeletePermisos( $id ){
//     return $this->db->table('permiso')
//     ->delete( ['idperfilpermiso' => $id] );
//   }

}
