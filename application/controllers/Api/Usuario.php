<?php
require APPPATH . 'libraries/REST_Controller.php';

class Usuario extends REST_Controller{
    public function __construct(){
        parent:: __construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('cors');
        $this->cors->handle();
      }

      public function login_post() {
        $input = $this->post();

        if (isset($input['Usuario']) && isset($input['Contrasena'])) {
            $usuario = $input['Usuario'];
            $contrasena = $input['Contrasena'];

            $user = $this->db->get_where('usuarios', array('Usuario' => $usuario, 'Contrasena' => $contrasena))->row_array();

            if ($user) {
                $this->session->set_userdata('usuarios', $user);
                $this->response(['data' => $user], REST_Controller::HTTP_OK);
            } else {
                $this->response(['error' => null], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(['error' => 1], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function logout_get() {
        $this->session->unset_userdata('usuarios');
        $this->response(['message' => 'Sesión cerrada'], REST_Controller::HTTP_OK);
    }

      public function index_options() {
        return $this->response(NULL, REST_Controller::HTTP_OK);
     }

      public function index_get($id=0){
        if(!empty($id)){
           $data = $this->db->get_where("usuarios", ["id_Usuario" => $id])->row_array();
        }
        else {
            $data = $this->db->get("usuarios")->result();
        }
    
        $this->response($data, REST_Controller::HTTP_OK);
      }
    
      public function index_post(){
        $input = $this->post();
        $this->db->insert("usuarios", $input);
        $this->response(['Usuario agregado'], REST_Controller::HTTP_OK);
      }
    
      public function index_put($id){
        $input = $this->put();
        $this->db->update("usuarios", $input, array("id_Usuario" => $id));
        $this->response(['Usuario actualizado'], REST_Controller::HTTP_OK);      
      }
    
      public function index_delete($id){
        $this->db->delete("usuarios", array("id_Usuario" => $id));
        $this->response(['Usuario eliminado'], REST_Controller::HTTP_OK); 
      }
}