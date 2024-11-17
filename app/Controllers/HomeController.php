<?php
namespace App\Controllers; 

use Core\Controller;
use App\Models\NestedSet;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function index() {
        $data['posts'] = $this->getPosts();
        $data['products'] = $this->getProducts();

        $data['title'] = 'QUOCBINH.ORG | GIẢI PHÁP WEBSITE';
        $data['body'] = 'home';
        $data['template'] = 'home/index';
        $this->view('client/index', ['data' => $data]);
    }

    private function getPosts() {
        // Xử lý posts
        $NestedSetPosts = new NestedSet($this->db, 'posts', 'post_languages');
        $posts = $NestedSetPosts->dropDown(
            $condition = [
                'tb1.image',
                'tb1.publish',
                'tb1.id',
                'tb1.post_catalogue_id',
            ],
            $join = [
                [
                    'tb2.name', 
                    'tb2.canonical',
                    'tb2.description',
                ]
            ],
            $data = [
                'publish' => $_GET['status'] ?? -1,
                'flag' => 1,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => $_GET['perpage'] ?? 3,
            ],
            'post_id'
        );
        $Post = new Post($this->db);
    
        foreach ($posts['result'] as $key => &$val) {
            $posts['result'][$key]['catalogues'] = $Post->loadParentCatalogue($val['post_catalogue_id']);
        }
        return $posts = $posts['result'];
    }
    
    private function getProducts() {
        $NestedSetProducts = new NestedSet($this->db, 'product', 'product_language');
        $product = $NestedSetProducts->dropDown(
            $condition = [
                'tb1.image',
                'tb1.publish',
                'tb1.id',
                'tb1.price',
                'tb1.sale',
            ],
            $join = [
                [
                    'tb2.name', 
                    'tb2.canonical',
                ]
            ],
            $data = [
                'publish' => $_GET['status'] ?? -1,
                'flag' => 1,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => 4,
            ],
            'product_id'
        );
        $Product = new Product($this->db);
    
        if(isset($product['result']) && (is_array($product['result']))){
            foreach ($product['result'] as $key => &$val) {
                $product['result'][$key]['catalogues'] = $Product->loadCatalogue($val['id']);
            }
        }
        return $product = $product['result'];
    }
    
}
