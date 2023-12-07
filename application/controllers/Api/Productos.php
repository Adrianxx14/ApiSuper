<?php
require APPPATH . 'libraries/REST_Controller.php';

class Productos extends REST_Controller{
    public function __construct(){
        parent:: __construct();
        $this->load->database();
        $this->load->library('cors');
        $this->cors->handle();
      }

      public function index_options() {
        return $this->response(NULL, REST_Controller::HTTP_OK);
      }
    
      public function index_get($id=0){
        if(!empty($id)){
           $data = $this->db->get_where("productos", ["id_Producto" => $id])->row_array();
        }
        else {
            $data = $this->db->get("productos")->result();
        }
    
        $this->response($data, REST_Controller::HTTP_OK);
      }
    
      public function index_post(){
        $input = $this->post();
        $this->db->insert("productos", $input);
        $this->response(['Producto agregado'], REST_Controller::HTTP_OK);
      }
    
      public function index_put($id){
        $input = $this->put();
        $this->db->update("productos", $input, array("id_Producto" => $id));
        $this->response(['Producto actualizado'], REST_Controller::HTTP_OK);      
      }
    
      public function index_delete($id){
        $this->db->delete("productos", array("id_Producto" => $id));
        $this->response(['Producto eliminado'], REST_Controller::HTTP_OK); 
      }
}