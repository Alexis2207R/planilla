<?php  
namespace App\Models;
use CodeIgniter\Model;

class ConfiguracionModel extends Model{
	protected $table            = 'configuracion';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $allowedFields    = ['nombre', 'direccion','pais','telefono','razon_social','ruc','registro_empresarial','ciudad','estado_confi','logo'];
    
	// public function mdlListarPerfiles(){
	// 	return $this->db->query('CALL prdListarUsuarios()')
	// 	->getResultArray();
	// }
	
    // public function session_valid($usuario,$clave){
    //     return $this->db->table('usuario u')
    //     ->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
    //     ->where(["u.estado" => '1', "u.usuario" => $usuario,"u.clave" => $clave, 'pe.estadoperfil' => '1'])
    //     ->get()->getResultArray();
    // }

	// public function get_mod($id_perfil){
	// 	return $this->db->table('permiso p')
	// 	->join('modulo m', 'm.id_modulo=p.idmodulo')
	// 	->where(['p.idperfilpermiso' => $id_perfil])
	// 	->get()->getResultArray();
	// }

	// public function getUsuario($id, $dni){
	// 	if ( $id == null) {
	// 		return $this->db->table('usuario u')
	// 		->where(['u.estado' => '1', 'u.dni' => $dni])
	// 		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
	// 		->get()->getResultArray();
	// 	} else {
	// 		return $this->db->table('usuario u')
	// 		->where(['u.estado' => '1', 'u.id_usuario' => $id])
	// 		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
	// 		->get()->getResultArray();
	// 	}
		
	// }
}
