<?php
 
namespace App\Controllers;
 
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ClientsModel;
 
 
class Clients extends BaseController
{
    use ResponseTrait;
    
    
    public function index()
    {

    
        $model = new ClientsModel();

        $data = $model->findAll();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found');
        }
         
    }

    public function show($id=null)
    {
        
        //if($this->validate($rules)){
            $model = new ClientsModel();
    
            $data = $model->getWhere(['id' => $id])->getResult();
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('No Data Found with id '.$id);
            }
        /*}else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);
             
        }*/
            
    }

    public function create()
    {
        $rules = [
            'name' => ['rules' => 'required|min_length[3]|max_length[255]|is_unique[tblclients.name]'],
            //'retainer_fee' => ['rules' => 'min_length[3]|max_length[255]'],
            'details' => ['rules' => 'required|min_length[3]|max_length[255]'],
        ];
            
  
        if($this->validate($rules)){
            $model = new ClientsModel();
            $data = [
                'name'   =>  $this->request->getVar('name'),
                'retainer_fee'   =>  $this->request->getVar('retainer_fee'),
                'details' => $this->request->getVar('details'),
            ];
            $model->save($data);
             
            return $this->respond(['message' => 'Client Created Successfully'], 200);
        }else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);
             
        }
            
    }

    public function update($id=null)
    {
        
        $model = new ClientsModel();
        $input = $this->request->getRawInput();
        $data = [
            'name' => $this->request->getVar('name'),
            'retainer_fee' => $this->request->getVar('retainer_fee'),
            'details' => $this->request->getVar('details')
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Client Info Updated'
            ]
        ];
        return $this->respond($response);
            
    }

    public function delete($id=null)
    {
        
        $model = new ClientsModel();

        $model->delete($id);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Client Deleted'
            ]
        ]; 
        
        
        return $this->respond($response);
            
    }



}