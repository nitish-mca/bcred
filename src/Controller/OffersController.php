<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Offers Controller
 *
 * @property \App\Model\Table\OffersTable $Offers
 */
class OffersController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Subcategories']
        ];
        $offers = $this->paginate($this->Offers);
        $categories = $this->Offers->Subcategories->Categories->find('list')->toArray();
        $this->set(compact('offers'));
        $this->set(compact('categories'));
        $this->set('_serialize', ['offers']);
    }

    /**
     * View method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $offer = $this->Offers->get($id, [
            'contain' => ['Subcategories']
        ]);
        $categories = $this->Offers->Subcategories->Categories->find('list')->toArray();
        
        $this->set('offer', $offer);
        $this->set(compact('categories'));
        $this->set('_serialize', ['offer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {        
        $offer = $this->Offers->newEntity();

        if ($this->request->is('post')) {
            $offer = $this->Offers->patchEntity($offer, $this->request->data);
            if(!empty($offer['url'])){
                $offer['urls'] = serialize(array_filter($offer['url']));
            }
            if(isset($offer->photo['name'])){
                $ext = pathinfo($offer->photo['name'], PATHINFO_EXTENSION);
                $filename = basename($offer->photo['name'], ".$ext");
                $offer->photo['name'] = md5($filename).'_'.rand(1,1000).'.'.$ext;
                
            }
            
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                if ($offer->errors()) {
                    $error_msg = [];
                    foreach ($offer->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(
                                __("Please fix the following error(s):" . implode("\n \r", $error_msg))
                        );
                    }
                }
                $this->Flash->error(__('The offer could not be saved. Please, try again.'));
            }
        }
        $catgories = $this->Offers->Subcategories->Categories->find()->contain(['Subcategories'])->toArray();
        
        $subcategorylist = array();
        
        foreach($catgories as $cat){
            $sb = array();            
            foreach($cat['subcategories'] as $subcat){
                $sb[$subcat['id']] = $subcat['title'];
            }
            $subcategories[$cat['title']] =  $sb;  
            
        }
        
        $this->set(compact('offer', 'subcategories'));
        $this->set('_serialize', ['offer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $offer = $this->Offers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $offer = $this->Offers->patchEntity($offer, $this->request->data);
            if(!empty($offer['url'])){
                $offer['urls'] = serialize(array_filter($offer['url']));
            }
            if(isset($offer->photo['name'])){
                $ext = pathinfo($offer->photo['name'], PATHINFO_EXTENSION);
                $filename = basename($offer->photo['name'], ".$ext");
                $offer->photo['name'] = md5($filename).'_'.rand(1,1000).'.'.$ext;   
            }
            //debug($offer);die;
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The offer could not be saved. Please, try again.'));
            }
        }
        $subcategories = $this->Offers->Subcategories->find('list', ['limit' => 200]);
        $this->set(compact('offer', 'subcategories'));
        $this->set('_serialize', ['offer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $offer = $this->Offers->get($id);
        if ($this->Offers->delete($offer)) {
            $this->Flash->success(__('The offer has been deleted.'));
        } else {
            $this->Flash->error(__('The offer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
