<?php

/** ******************************
 * @author  :   Yêu Tinh
 * @email   :   domain.web.online@gmail.com
 * @since   :   8-07-2013
 *********************************/
 
class ExttmptwosController extends AppController {

    public $name = 'Exttmptwos';
    public $uses = array('Exttmp');
    
    public $type = 'color';
    public $only_one = false;
    
    public $max_img = 1000;
    public $img_width = 0;//set width of image after upload
    public $img_height = 0;// 0 -> auto
    
    public function beforeFilter() {
        parent::beforeFilter();
        if(in_array($this->request->params['action'],array('index','search'))) $this->save_url();
    }
 
    public function index() {
        
        
        if($this->request->is('post')){

            if($this->request->data['option'] == 'order'){
                foreach($this->request->data['order'] as $key => $value){
                    $this->Exttmp->id = $key;
                    $this->Exttmp->saveField('order',$value);
                }
                if(isset($this->notice['order'])) $this->Session->setFlash($this->notice['order'], 'default', array('class' => 'notification success png_bg'));
                $this->cancel();
            }
            else if($this->request->data['option'] == 'active'){
                if(isset($this->request->data['check']))
                {
                    if($this->only_one){
                        if(count($this->request->data['check'])>1){
                            if(isset($this->notice['only_one'])) $this->Session->setFlash($this->notice['only_one'], 'default', array('class' => 'notification error png_bg'));
                        }
                        else{
                            $check = array_keys($this->request->data['check']);
                            $this->Exttmp->updateAll(array('Exttmp.status' => 0), array('Exttmp.type' => $this->type));
                            $this->Exttmp->id = $check[0];
                            $this->Exttmp->saveField('status', 1);
                            if(isset($this->notice['active_many'])) $this->Session->setFlash($this->notice['active_many'], 'default', array('class' => 'notification success png_bg'));
                        }
                    }
                    else{
                        foreach($this->request->data['check'] as $key => $value){
                            $this->Exttmp->id = $key;
                            $this->Exttmp->saveField('status','1');
                        }
                        if(isset($this->notice['active_many'])) $this->Session->setFlash($this->notice['active_many'], 'default', array('class' => 'notification success png_bg'));
                    }
                }
                else if(isset($this->notice['empty_select'])) $this->Session->setFlash($this->notice['empty_select'], 'default', array('class' => 'notification attention png_bg'));
                $this->cancel();
            }
            else if($this->request->data['option'] == 'close'){
                if(isset($this->request->data['check']))
                {
                    foreach($this->request->data['check'] as $key => $value){
                        $this->Exttmp->id = $key;
                        $this->Exttmp->saveField('status','0');
                    }
                    if(isset($this->notice['colse_many'])) $this->Session->setFlash($this->notice['colse_many'], 'default', array('class' => 'notification success png_bg'));
                }
                else if(isset($this->notice['empty_select'])) $this->Session->setFlash($this->notice['empty_select'], 'default', array('class' => 'notification attention png_bg'));
                $this->cancel();
            }
            else if($this->request->data['option'] == 'delete'){
                if(isset($this->request->data['check']))
                {
                    foreach($this->request->data['check'] as $key => $value){
                        
                        $delete = $this->Exttmp->findById($key);
                        
                        $this->Upload->delete = $delete['Exttmp']['images'];
                        $this->Upload->Process();
                        
                        $this->Exttmp->delete($key);
                    }
                    if(isset($this->notice['delete_many'])) $this->Session->setFlash($this->notice['delete_many'], 'default', array('class' => 'notification success png_bg'));
                }
                else if(isset($this->notice['empty_select'])) $this->Session->setFlash($this->notice['empty_select'], 'default', array('class' => 'notification attention png_bg'));
                $this->cancel();
            }
        }
        
        $this->paginate = array(
            'conditions'=>array('Exttmp.type'=>$this->type),
            'order' => array('Exttmp.order'=>'DESC','Exttmp.id' => 'DESC'),
            'limit' => '10'
        );
        
        $this->set('view', $this->paginate('Exttmp'));
    }

    public function add() {
        if (!empty($this->request->data)) {
            $this->Exttmp->set($this->request->data);
            if ($this->Exttmp->validates()) {
                
                if($this->only_one) if($this->request->data['Exttmp']['status']) $this->Exttmp->updateAll(array('Exttmp.status' => 0), array('Exttmp.type' => $this->type));
                
                $this->request->data['Exttmp']['type'] = $this->type;
                $this->request->data['Exttmp']['user_id'] = $_SESSION['id'];
                
                $this->Exttmp->save($this->request->data);
                if(isset($this->notice['add_success'])) $this->Session->setFlash($this->notice['add_success'], 'default', array('class' => 'notification success png_bg'));
                
                $bak_after_save = $this->Session->read('back_after_save');
                if(!empty($bak_after_save)) $this->redirect($bak_after_save);
                else $this->redirect(array('action' => 'index'));
            }
            else {
                if(isset($this->notice['add_failed'])) $this->Session->setFlash($this->notice['add_failed'], 'default', array('class' => 'notification attention png_bg'));
            }
        }
        else{
            $order = $this->Exttmp->find('first',array('conditions'=>array('type'=>$this->type),'order' => array('order' => 'DESC')));
            if(isset($order['Exttmp']['order'])) $this->request->data['Exttmp']['order'] = $order['Exttmp']['order'] + 1 ; else $this->request->data['Exttmp']['order'] = 0;
            $this->Session->write('back_after_save',$this->referer());
        }
    }

    public function edit($id = null) {
        if (!empty($this->request->data)) {
            
            $this->Exttmp->set($this->request->data);
            if ($this->Exttmp->validates()) {
                
                if($this->only_one) if($this->request->data['Exttmp']['status']) $this->Exttmp->updateAll(array('Exttmp.status' => 0), array('Exttmp.type' => $this->type));
                
                $this->request->data['Exttmp']['type'] = $this->type;
                $this->request->data['Exttmp']['user_id_edit'] = $_SESSION['id'];
                
                $this->Exttmp->save($this->request->data);
                if(isset($this->notice['edit_success'])) $this->Session->setFlash($this->notice['edit_success'], 'default', array('class' => 'notification success png_bg'));;
                
                $bak_after_save = $this->Session->read('back_after_save');
                if(!empty($bak_after_save)) $this->redirect($bak_after_save);
                else $this->redirect(array('action' => 'index'));  
            }
            else{
                if(isset($this->notice['edit_failed'])) $this->Session->setFlash($this->notice['edit_failed'], 'default', array('class' => 'notification attention png_bg'));
            }
        }
        else{
            $this->request->data = $this->Exttmp->findById($id);
            if (empty($this->request->data)){
                if(isset($this->notice['not_exist'])) $this->Session->setFlash($this->notice['not_exist'], 'default', array('class' => 'notification error png_bg'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function delete($id = null) {
        
        $delete = $this->Exttmp->findById($id);
        if (!$delete) {
            if(isset($this->notice['not_exist'])) $this->Session->setFlash($this->notice['not_exist'], 'default', array('class' => 'notification error png_bg'));
            $this->cancel();
        }
        else{
            
            $this->Exttmp->delete($id);
            if(isset($this->notice['delete_success'])) $this->Session->setFlash($this->notice['delete_success'], 'default', array('class' => 'notification success png_bg'));
            $this->cancel();
        }
    }
    
    public function close($id = null) {
        if($this->only_one) $this->cancel();
        $this->Exttmp->id = $id;
        $this->Exttmp->saveField('status', 0);
        if(isset($this->notice['close'])) $this->Session->setFlash($this->notice['close'], 'default', array('class' => 'notification success png_bg'));
        $this->cancel();
    }

    public function active($id = null) {
        if($this->only_one) $this->Exttmp->updateAll(array('Exttmp.status' => 0), array('Exttmp.type' => $this->type));
        $this->Exttmp->id = $id;
        $this->Exttmp->saveField('status', 1);
        if(isset($this->notice['active'])) $this->Session->setFlash($this->notice['active'], 'default', array('class' => 'notification success png_bg'));
        $this->cancel();
    }

}