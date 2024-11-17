<?php
namespace App\Controllers; 

use Core\Controller;
use App\Models\NestedSet;
use App\Models\Post;

class BlogController extends Controller {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index() {
        $Post = new Post($this->db);
        $condition = [
            [
                'tb1.post_catalogue_id',
                'tb1.image',
                'tb1.updated_at',
            ],
            [
                'tb2.name',
                'tb2.description',
                'tb2.canonical',
            ],
        ];

        $data['cat'] = $_GET['cat'] ?? '';
        $data['keyword'] = $_GET['keyword'] ?? '';

        $data['postCatalogue'] = $this->getPostCatalogue();
       
        $data['posts'] = $Post->getBlogWithCataloge($condition, $data['cat'], $data['keyword']);
        foreach ($data['posts'] as &$val) {
            $val['nameCatalogue'] = $Post->loadNameCatalogue($val['post_catalogue_id'])['name'];
            $val['canonicalCatalogue'] = $Post->loadNameCatalogue($val['post_catalogue_id'])['canonical'];
        }

        $data['body'] = 'blog';
        $data['title'] = 'Blog | QUOCBINH.ORG GIẢI PHÁP WEBSITE';
        $data['template'] = 'blog/index';
        $this->view('client/index', ['data' => $data]);
    }

    public function detail($slug)
    {
        $Post = new Post($this->db);
        $condition = [
            [
                'tb1.*',
            ],
            [
                'tb2.*',
            ],
        ];
        $data['detail'] = $Post->getBlogWithSlug($condition, $slug);

        $data['detail']['nameCatalogue'] = $Post->loadNameCatalogue($data['detail']['post_catalogue_id'])['name'];
        $data['detail']['catalogue'] = $Post->loadCatalogue($data['detail']['id']);

        $conditionAttr = [
            [
                'tb1.id',
                'tb1.post_catalogue_id',
                'tb1.image',
                'tb1.updated_at',
            ],
            [
                'tb2.name',
                'tb2.canonical',
                'tb2.description',
            ],
        ];
        $data['postAttr'] = $Post->getBlogAttrSlug($conditionAttr, $slug);
        foreach ($data['postAttr'] as &$val) {
            $val['nameCatalogue'] = $Post->loadNameCatalogue($val['post_catalogue_id'])['name'];
        }

        // print_r($data['postAttr']); die();

        $data['body'] = 'blog';
        $data['title'] = $data['detail']['name'];
        $data['template'] = 'blog/detail';

        $this->view('client/index', ['data' => $data]);
    }

    private function getPostCatalogue() {
        $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
        $posts = $NestedSet->dropDown(
            $condition = [
                'tb1.id',
                'tb1.parent_id',
                'tb1.image',
                'tb1.depth',
            ],
            $join = [
                [
                    'tb2.name', 
                    'tb2.canonical',
                ]
            ],
            $data = [
                'publish' => 1,
                'flag' => 1,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => 10000,
            ],
            'post_catalogue_id'
        );
        return $posts = $posts['result'];
    }
    
    private function getBlogs() {
        $NestedSet = new NestedSet($this->db, 'posts', 'post_languages');
        $posts = $NestedSet->dropDown(
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
                'publish' => 1,
                'flag' => 1,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => 10000,
            ],
            'post_id'
        );
        return $posts = $posts['result'];
    }
}
