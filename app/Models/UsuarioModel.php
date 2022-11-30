<?php  
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model{
	protected $table            = 'usuario';
	protected $primaryKey       = 'id_usuario';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $allowedFields    = ['nombre', 'apellido','usuario','clave','estado','dni','telefono','idperfil_usuario','correo','direccion','estado_clave', 'fecha_clave'];
    
	public function mdlListarPerfiles(){
		return $this->db->query('CALL prdListarUsuarios()')
		->getResultArray();
	}
	
    public function session_valid($usuario,$clave){
        return $this->db->table('usuario u')
        ->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
        ->where(["u.estado" => '1', "u.usuario" => $usuario,"u.clave" => $clave, 'pe.estadoperfil' => '1'])
        ->get()->getResultArray();
    }

	public function get_mod($id_perfil){
		return $this->db->table('permiso p')
		->join('modulo m', 'm.id_modulo=p.idmodulo')
		->where(['p.idperfilpermiso' => $id_perfil])
		->get()->getResultArray();
	}

	public function getUsuario($id, $dni){
		if ( $id == null) {
			return $this->db->table('usuario u')
			->where(['u.estado' => '1', 'u.dni' => $dni])
			->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
			->get()->getResultArray();
		} else {
			return $this->db->table('usuario u')
			->where(['u.estado' => '1', 'u.id_usuario' => $id])
			->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
			->get()->getResultArray();
		}
	}
}
