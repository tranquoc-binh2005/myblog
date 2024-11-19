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
        $data['seo'] = [
            'meta_title' => 'Source-code | QUOCBINH.ORG | Giải pháp IT dành cho bạn',
            'meta_keyword' => 'Lập trình web - Fullstack - Laravel - Tự học lập trình - Lập trình cơ bản',
            'meta_description' => 'Giải pháp IT dành cho bạn',
            'canonical' => 'blog',
            'image' => '',
            'nameWeb' => 'QUOCBINH ORG | Giải pháp IT dành cho bạn'
        ];
        $data['title'] = 'Blog | QUOCBINH.ORG | Giải pháp IT dành cho bạn';

        $data['config'] = [
            'css' => [
                '<link rel="stylesheet" href="client/assets/css/style.css">',
            ],
        ];


        $data['body'] = 'blog';
        $data['template'] = 'blog/index';
        $this->view('client/index', ['data' => $data]);
    }

    public function detail($slug)
    {
        $Post = new Post($this->db);
        $condition = [
            [
                'tb1.id',
                'tb1.post_catalogue_id',
                'tb1.image',
                'tb1.updated_at',
                'tb1.created_at',
            ],
            [
                'tb2.name',
                'tb2.canonical',
                'tb2.content',
                'tb2.description',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
            ],
        ];
        $data['detail'] = $Post->getBlogWithSlug($condition, $slug);

        $data['detail']['nameCatalogue'] = $Post->loadNameCatalogue($data['detail']['post_catalogue_id'])['name'];
        $data['detail']['catalogue'] = $Post->loadCatalogue($data['detail']['id']);

        $data['seo'] = [
            'meta_title' => $data['detail']['meta_title'],
            'meta_keyword' => $data['detail']['meta_keyword'],
            'meta_description' => $data['detail']['meta_description'],
            'canonical' => 'blog/' .$data['detail']['canonical'],
            'image' => $data['detail']['image'],
            'nameWeb' => 'QUOCBINH ORG | Giải pháp IT dành cho bạn'
        ];

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
