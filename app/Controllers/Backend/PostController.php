<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\Post;
use App\Models\NestedSet;
use App\Models\Base;
use App\Requests\PostRequest;

class PostController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'];

        $NestedSet = new NestedSet($this->db, 'posts', 'post_languages');
        $data['dropDowns'] = $NestedSet->dropDown(
            $condition = [
                'tb1.image',
                'tb1.publish',
                'tb1.id',
            ],
            $join = [
                [
                    'tb2.name', 
                    'tb2.canonical',
                ]
            ],
            $data = [
                'publish' => $_GET['status'] ?? -1,
                'flag' => $flag,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => $_GET['perpage'] ?? 10,
            ],
            'post_id'
        );
        $Post = new Post($this->db);
        foreach ($data['dropDowns']['result'] as $key => &$val) {
            $data['dropDowns']['result'][$key]['catalogues'] = $Post->loadCatalogue($val['id']);
        }

        $data['total_pages'] = $data['dropDowns']['totalPage'];
        $data['current_page'] = $data['dropDowns']['currentPage'];
        $data['dropDowns'] = $data['dropDowns']['result'];

        $data['template'] = 'post/index';
        $data['title'] = $GLOBALS['sub']['post']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['post']['title']['create'];
            $data['template'] = 'post/store';

            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $data['dropDowns'] = $NestedSet->dropDown(
                $condition = [
                    'tb1.id',
                    'tb1.parent_id',
                    'tb1.publish',
                    'tb1.depth',
                ],
                $join = [
                    'tb2.name'
                ],
                [],
                'post_catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'xu-ly-tao-bai-viet';

            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'content' => $_POST['content'] ?? null,
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'canonical' => $_POST['canonical'],
                'post_catalogue_id' => $_POST['post_catalogue_id'],
                'catalogue' => $_POST['catalogue'],
                'image' => $_POST['image'] ?? null,
                'album' => $_POST['album'] ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];

            $data['language_id'] = $this->getLanguage();

            $request = new PostRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $Post = new Post(
                    $this->db,
                    $data['post_catalogue_id'], 
                    $data['image'], 
                    json_encode($data['album']), 
                    $data['publish'], 
                    $data['follow'], 
                    $data['user_id'], 

                    $data['language_id'], 
                    $data['name'], 
                    $data['description'], 
                    $data['content'], 
                    $data['canonical'], 
                    $data['meta_title'], 
                    $data['meta_keyword'], 
                    $data['meta_description'], 
                    $data['catalogue'], 
                );
                $result = $Post->save('posts', 'post_languages');
                if ($result) {
                    alertSuccess('Thành công', 'Tạo bản ghi thành công', 'bai-viet');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-bai-viet');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
                $data['dropDowns'] = $NestedSet->dropDown(
                    $condition = [
                        'tb1.id',
                        'tb1.parent_id',
                        'tb1.publish',
                        'tb1.depth',
                    ],
                    $join = [
                        'tb2.name'
                    ],
                    [],
                    'post_catalogue_id'
                );   
                $data['dropDowns'] = $data['dropDowns']['result'];

                $errors = $validationResult;
                $data['template'] = 'post/store';
                $data['title'] = $GLOBALS['sub']['post']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        } else {
            echo 'Phương thức không hợp lệ.';
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'content' => $_POST['content'] ?? null,
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'canonical' => $_POST['canonical'],
                'post_catalogue_id' => $_POST['post_catalogue_id'],
                'catalogue' => $_POST['catalogue'],
                'image' => $_POST['image'] ?? null,
                'album' => json_encode($_POST['album']) ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];

            $payload['language_id'] = $this->getLanguage();

            $request = new PostRequest($this->db);
            $validationResult = $request->store($payload);
            if (isset($validationResult['success'])) {
                $Post = new Post(
                    $this->db,
                    $payload['post_catalogue_id'], 
                    $payload['image'], 
                    $payload['album'], 
                    $payload['publish'], 
                    $payload['follow'], 
                    $payload['user_id'], 

                    $payload['language_id'], 
                    $payload['name'], 
                    $payload['description'], 
                    $payload['content'], 
                    $payload['canonical'], 
                    $payload['meta_title'], 
                    $payload['meta_keyword'], 
                    $payload['meta_description'], 
                    $payload['catalogue'], 
                );
                $result = $Post->update('posts', 'post_languages', $id);

                if ($result) {
                    alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../bai-viet');
                } else {
                    alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-bai-viet/' . $id . '');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'posts', 'post_languages');
                $data['dropDowns'] = $NestedSet->dropDown(
                    $condition = [],
                    $join = ['tb2.name'],
                    $payload = [
                        'flag' => 0,
                    ],
                );
                $errors = $validationResult;
                $data['template'] = 'post/store';
                $data['title'] = $GLOBALS['sub']['post']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $condition = [
                'tb1.image',
                'tb1.id',
                'tb1.album',
                'tb1.post_catalogue_id as parent_id',
            ];
            $join = [
                'tb2.name', 
                'tb2.description', 
                'tb2.content', 
                'tb2.canonical', 
                'tb2.meta_title', 
                'tb2.meta_keyword', 
                'tb2.meta_description', 
                'tb3.post_catalogue_id'
            ];
            $Post = new Post($this->db);
            $data['post'] = $Post->loadPost($condition,$join, $id);
            $data['catalogue'] = $data['post']['post_catalogue_id'];
            $data['post'] = $data['post']['result'][0];
            $data['post']['album'] = json_decode($data['post']['album'], true);

            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $data['dropDowns'] = $NestedSet->dropDown(
                $condition = [
                    'tb1.id',
                    'tb1.parent_id',
                    'tb1.publish',
                    'tb1.depth',
                ],
                $join = [
                    'tb2.name'
                ],
                [],
                'post_catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'sua-bai-viet/' . $id . '';

            $data['title'] = $GLOBALS['sub']['post']['title']['update'];
            $data['template'] = 'post/store';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Base = new Base($this->db);
            $result = $Base-> softDelete($id, 'posts');
            if ($result) {
                alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-bai-viet/' . $id . '');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Post = new Post($this->db);
            $data['post'] = $Post->findPost($id);

            $data['title'] = $GLOBALS['sub']['post']['title']['delete'];
            $data['template'] = 'post/destroy';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $NestedSet = new NestedSet($this->db, 'posts', 'post_languages');
            $result = $NestedSet->delete($id);
            if ($result) {
                alertSuccess('Thành công', 'Xoá bản ghi thành công', '../bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-bai-viet/' . $id . '');
            }
        }
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $Base = new Base($this->db);
            $result = $Base->restore($id, 'posts');
            // $NestedSet = new NestedSet($this->db, 'posts', 'post_languages');
            // $result = $NestedSet->restore($id);
            if ($result) {
                alertSuccess('Thành công', 'Hoàn tác bản ghi thành công', '../bai-viet');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../bai-viet');
            }
        }
    }

    private function getLanguage()
    {
        return 1;
    }
}
