<?php
namespace App\Models;
use CodeIgniter\Model;

class PerfilModel extends Model{
	
  protected $table = 'perfil';
  protected $primaryKey = 'id_perfil';
  protected $returnType = 'array';
  protected $allowedFields = ['nombreperfil','estadoperfil'];

  public function mdlListarPerfiles(){
    return $this->db->query('CALL prdListarPerfiles()')
    ->getResultArray();
  }

  public function mdlModulos( $idperfil ){
    return $this->db->table('permiso p')
    ->join('modulo m', 'p.idmodulo=id_modulo')
    ->join('perfil pe', 'p.idperfilpermiso = pe.id_perfil')
    ->where([ 'm.estadomodulo' => 1, 'p.idperfilpermiso' => $idperfil ])
    ->get()->getResultArray();
  }

  public function mdlListaModulos(){
    return $this->db->table('modulo')
    ->where( [ 'estadomodulo' => 1] )
    ->get()->getResultArray();
  }

  public function mdlInsertPermisos( $datos ){
    return $this->db->table('permiso')
    ->insert( $datos );
  }

  public function mdlDeletePermisos( $id ){
    return $this->db->table('permiso')
    ->delete( ['idperfilpermiso' => $id] );
  }

}
