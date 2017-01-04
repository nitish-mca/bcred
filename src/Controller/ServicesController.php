<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class ServicesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['getcategories', 'getsubcategories', 'getofferslist', 'getofferdetails',
            'addsubsricption', 'addsuggestions', 'listoffers', 'search', 'globalsearch']);
    }

    public function getcategories() {
        $this->loadModel('Categories');
        $categories = $this->Categories->find('all', [
            'limit' => 25,
            'order' => 'Categories.id ASC'
        ]);
        echo json_encode($categories);
        die;
    }

    public function getsubcategories($category_id) {
        $this->loadModel('Subcategories');
        $subcategories = $this->Subcategories->find()
                ->limit(25)
                ->where(['Subcategories.category_id' => $category_id])
                ->order('Subcategories.id');

        echo json_encode($subcategories);
        die;
    }

    public function getofferslist($subcategory_id) {
        $this->loadModel('Offers');
        $offerlist = $this->Offers->find('all', [
            'limit' => 25,
            'fields' => ['id', 'title', 'subtitle'],
            'where' => ['subcategory_id' => $subcategory_id],
            'order' => 'Offers.id ASC'
        ]);
        echo json_encode($offerlist);
        die;
    }

    public function getofferdetails($offer_id) {
        $this->loadModel('Offers');
        $offer = $this->Offers->get($offer_id, ['contain' => ['Subcategories']])->toArray();
        $offer['urls'] = !empty($offer['urls']) ? unserialize($offer['urls']) : '';
        $offer['photo'] = !empty($offer['photo']) ? '/Offers/photo/' . $offer['photo'] : '';
        unset($offer['dir'], $offer['is_expired']);
        echo json_encode($offer);
        die;
    }

    public function addsubsricption() {
        $this->loadModel('Subscriptions');
        $subscription = $this->Subscriptions->newEntity();
        $msg = array('msg' => 'Please Send email address in post method.', 'success' => false, 'error' => true);
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->data);
            //debug($subscription);die;
            if ($this->Subscriptions->save($subscription)) {
                $msg = array('msg' => 'The subscription has been saved.', 'success' => true, 'error' => false);
            } else {
                $msg = array('msg' => 'The subscription could not been saved. Please try again.', 'success' => false, 'error' => true);
            }
        }
        echo json_encode($msg);
        die;
    }

    public function addsuggestions() {
        $this->loadModel('Suggestions');
        $msg = array('msg' => 'Your suggestion could not been sent. Please try again.', 'success' => false, 'error' => true);
        $suggestion = $this->Suggestions->newEntity();
        if ($this->request->is('post')) {
            $suggestion = $this->Suggestions->patchEntity($suggestion, $this->request->data);
            if ($this->Suggestions->save($suggestion)) {
                $msg = array('msg' => 'Your suggestion has been sent successfully.', 'success' => true, 'error' => false);
            } else {
                $msg = array('msg' => 'Your suggestion could not been sent. Please try again.', 'success' => false, 'error' => true);
            }
        }
        echo json_encode($msg);
        die;
    }

    public function listoffers($category_id) {
        $this->loadModel('Subcategories');
        $subcategories = $this->Subcategories->find()
                ->contain(['Categories', 'Offers'])
                ->limit(25)
                ->where(['Subcategories.category_id' => $category_id])
                ->order('Subcategories.id')
                ->toArray();
        $data = array();
        foreach ($subcategories as $k => $sb) {
            if (!empty($sb['offers'])) {
                $data[$k]['id'] = $sb['id'];
                $data[$k]['title'] = $sb['title'];
                $data[$k]['category'] = $sb['category']->title;
                $data[$k]['totalOffers'] = count($sb['offers']);
                foreach ($sb['offers'] as $i => $offer) {
                    $data[$k]['offers'][$i]['id'] = $offer['id'];
                    $data[$k]['offers'][$i]['title'] = $offer['title'];
                    $data[$k]['offers'][$i]['subtitle'] = $offer['subtitle'];
                    $data[$k]['offers'][$i]['photo'] = !empty($offer['photo']) ? '/img/Offers/photo/' . $offer['photo'] : '';
                    $data[$k]['offers'][$i]['urls'] = !empty($offer['urls']) ? unserialize($offer['urls']) : '';
                    $data[$k]['offers'][$i]['description'] = $offer['description'];
                    $data[$k]['offers'][$i]['email'] = $offer['email'];
                    $data[$k]['offers'][$i]['phone'] = $offer['phone'];
                    $data[$k]['offers'][$i]['facetime_phone'] = $offer['facetime_phone'];
                }
            }
        }
        echo json_encode($data);
        die;
    }

    public function globalsearch() {
        $key = !empty($this->request->data['key']) ? $this->request->data['key'] : '';
        $connection = ConnectionManager::get('default');
        $offerlist = $connection->execute(
                        "SELECT O.*, S.id as Subcat_id, S.title as Subcat_title, C.id as Cat_id, C.title as Cat_title FROM offers O "
                        . "JOIN subcategories S ON O.subcategory_id = S.id "
                        . "JOIN categories C on S.category_id = C.id "
                        . "WHERE O.title LIKE '%" . $key . "%' "
                        . "OR O.subtitle LIKE '%" . $key . "%' "
                        . "OR C.title LIKE '%" . $key . "%' "
                        . "OR S.title LIKE '%" . $key . "%'"
                )->fetchAll('assoc');

        $data = array();
        foreach ($offerlist as $i => $offer) {
            $data[$i]['cateogry']['id'] = $offer['Cat_id'];
            $data[$i]['cateogry']['title'] = $offer['Cat_title'];
            $data[$i]['subcategory']['id'] = $offer['Subcat_id'];
            $data[$i]['subcategory']['title'] = $offer['Subcat_title'];
            $data[$i]['offers']['id'] = $offer['id'];
            $data[$i]['offers']['title'] = $offer['title'];
            $data[$i]['offers']['subtitle'] = $offer['subtitle'];
            $data[$i]['offers']['photo'] = !empty($offer['photo']) ? '/img/Offers/photo/' . $offer['photo'] : '';
            $data[$i]['offers']['urls'] = !empty($offer['urls']) ? unserialize($offer['urls']) : '';
            $data[$i]['offers']['description'] = $offer['description'];
            $data[$i]['offers']['email'] = $offer['email'];
            $data[$i]['offers']['phone'] = $offer['phone'];
            $data[$i]['offers']['facetime_phone'] = $offer['facetime_phone'];
        }
        
        echo json_encode($data);
        die;
    }
    
    public function search() {
        $key = !empty($this->request->data['key']) ? $this->request->data['key'] : '';
        $connection = ConnectionManager::get('default');
        $offerlist = $connection->execute(
                        "SELECT O.*, S.id as Subcat_id, S.title as Subcat_title, C.id as Cat_id, C.title as Cat_title FROM offers O "
                        . "JOIN subcategories S ON O.subcategory_id = S.id "
                        . "JOIN categories C on S.category_id = C.id "
                        . "WHERE O.title LIKE '%" . $key . "%' "
                        . "OR O.subtitle LIKE '%" . $key . "%' "
                        . "OR C.title LIKE '%" . $key . "%' "
                        . "OR S.title LIKE '%" . $key . "%'"
                )->fetchAll('assoc');

        $data = array();
        
        foreach ($offerlist as $k => $offer) {
            $data[$k]['id'] = $offer['Subcat_id'];
            $data[$k]['title'] = $offer['Subcat_title'];
            $data[$k]['category'] = $offer['Cat_title'];
            $data[$k]['totalOffers'] = 1;
            $data[$k]['offers'][0]['id'] = $offer['id'];
            $data[$k]['offers'][0]['title'] = $offer['title'];
            $data[$k]['offers'][0]['subtitle'] = $offer['subtitle'];
            $data[$k]['offers'][0]['photo'] = !empty($offer['photo']) ? '/img/Offers/photo/' . $offer['photo'] : '';
            $data[$k]['offers'][0]['urls'] = !empty($offer['urls']) ? unserialize($offer['urls']) : '';
            $data[$k]['offers'][0]['description'] = $offer['description'];
            $data[$k]['offers'][0]['email'] = $offer['email'];
            $data[$k]['offers'][0]['phone'] = $offer['phone'];
            $data[$k]['offers'][0]['facetime_phone'] = $offer['facetime_phone'];
        }

        echo json_encode($data);
        die;
    }

}
