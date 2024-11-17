<?php
namespace App\Controllers; 

use Core\Controller;
use App\Models\Post;
use App\Models\NestedSet;
use App\Models\Product;


class ProductController extends Controller {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function index() {
        $Product = new Product($this->db);
        $condition = [
            [
                'tb1.catalogue_id',
            ],
            [
                'tb2.product_id',
                'tb2.name',
            ],
            [
                'tb3.price',
                'tb3.sale',
                'tb3.image',
            ],
        ];

        $data['keyword'] = $_GET['keyword'] ?? '';
        $data['cat'] = $_GET['cat'] ?? '';

        $data['products'] = (isset($data['cat']) && (!empty($data['cat']))) ? $Product->getProductWithCatalogue($condition, $data['cat'], $data['keyword']) : $this->getProducts($data['keyword'])['product'];

        $data['catalogues'] = $this->getCatalogues();
        if(isset($data['catalogues']) && (is_array($data['catalogues']))){
            foreach ($data['catalogues'] as &$cata) {
                $cata['count'] = $this->countProduct($cata['id']);
            }
        }

        $data['config'] = [
            'css' => [

            ],
            'js' => [
                '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>',
            ]
            ];

        $data['body'] = 'source';
        $data['template'] = 'product/index';
        $this->view('client/index', ['data' => $data]);
    }

    public function detail($slug)
    {
        $Product = new Product($this->db);
        $condition = [
            [
                'tb1.id',
                'tb1.parent_id',
                'tb1.price',
                'tb1.sale',
                'tb1.image',
            ],
            [
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
            ],
        ];
        $data['detail'] = $Product->getProductWithSlug($condition, $slug);

        $data['detail']['catalogueName'] = $Product->loadNameCatalogue($data['detail']['parent_id'])['name'];

        $data['detail']['catalogue'] = $Product->loadCatalogue($data['detail']['id']);

        $conditionAttr = [
            [
                'tb1.id',
                'tb1.price',
                'tb1.sale',
                'tb1.image',
            ],
            [
                'tb2.name',
                'tb2.canonical',
                'tb2.description',
            ],
        ];
        $data['productAttr'] = $Product->getProductAttrSlug($conditionAttr, $slug);

        $data['body'] = 'blog';
        $data['title'] = $data['detail']['name'];
        $data['template'] = 'product/detail';

        $this->view('client/index', ['data' => $data]);
    }

    private function countProduct($catalogue_id)
    {
        $Product = new Product($this->db);
        return $Product->countProduct($catalogue_id);
    }

    private function getProducts($keyword) {
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
                    'tb2.description',
                ]
            ],
            $data = [
                'publish' => 1,
                'flag' => 1,
                'keyword' => $keyword,
                'page' => $_GET['page'] ?? 1,
                'perPage' => 6,
            ],
            'product_id'
        );
        $Product = new Product($this->db);
    
        if(isset($product['result']) && (is_array($product['result']))){
            foreach ($product['result'] as $key => &$val) {
                $product['result'][$key]['catalogues'] = $Product->loadCatalogue($val['id']);
            }
        }

        return [
            'product' => $product['result'],
            'total_pages' => $product['totalPage'],
            'current_page' => $product['currentPage'],
        ];
    }

    private function getCatalogues()
    {
        $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
        $catalogues = $NestedSet->dropDown(
            $condition = [
                'tb1.id',
                'tb1.parent_id',
            ],
            $join = [
                [
                    'tb2.name', 
                ]
            ],
            $data = [
                'publish' => 1,
                'flag' => 1,
                'keyword' => '',
                'page' => 1,
                'perPage' => 100000,
            ],
            'catalogue_id'
        );

        return $catalogues = $catalogues['result'];
    }
}
