<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\PostCatalogue;
use App\Models\NestedSet;
use App\Models\PostCatalogueCatalogue;
use App\Models\Base;
use App\Requests\PostCatalogueRequest;

class PostCatalogueController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $PostCatalogue = new PostCatalogue($this->db);
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'];

        $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
        $data['dropDowns'] = $NestedSet->dropDown(
            $condition = [
                'tb1.id',
                'tb1.parent_id',
                'tb1.publish',
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
                'publish' => $_GET['status'] ?? -1,
                'flag' => $flag,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => $_GET['perpage'] ?? 10,
            ],
            'post_catalogue_id'
        );

        $data['total_pages'] = $data['dropDowns']['totalPage'];
        $data['current_page'] = $data['dropDowns']['currentPage'];
        $data['dropDowns'] = $data['dropDowns']['result'];

        $data['template'] = 'postCatalogue/index';
        $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['create'];
            $data['postCatalogues'] = $this->BaseModel->all('user_catalogue');
            $data['template'] = 'postCatalogue/store';

            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $data['dropDowns'] = $NestedSet->dropDown(
                $condition = [
                    'tb1.id',
                    'tb1.parent_id',
                    'tb1.publish',
                    'tb1.depth',
                ],
                $join = [
                    [
                        'tb2.name', 
                        'tb2.canonical',
                    ]
                ],
                [],
                'post_catalogue_id'
            ); 
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'xu-ly-tao-nhom-bai-viet';

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
                'parent_id' => $_POST['parent_id'],
                'image' => $_POST['image'] ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];
            $data['field'] = ['parent_id', 'lft', 'rgt', 'depth', 'publish', 'follow', 'user_id', 'image'];
            $data['primary'] = ['post_catalogue_id', 'language_id'];

            $request = new PostCatalogueRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
                $result = $NestedSet->insert($data, $data['parent_id'], $data['primary']);

                if ($result) {
                    alertSuccess('Thành công', 'Tạo bản ghi thành công', 'nhom-bai-viet');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-nhom-bai-viet');
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
                        [
                            'tb2.name', 
                            'tb2.canonical',
                        ]
                    ],
                    [],
                    'post_catalogue_id'
                ); 
                $errors = $validationResult;
                $data['template'] = 'postCatalogue/store';
                $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['create'];
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
                'publish', 
                'follow',
                'image'
            ];
            $payloadPivot = [
                'name',
                'description', 
                'canonical', 
                'content', 
                'meta_title', 
                'meta_keyword', 
                'meta_description', 
                'post_catalogue_id',
                'language_id',
            ]; 
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'content' => $_POST['content'] ?? null,
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'canonical' => $_POST['canonical'],
                'parent_id' => $_POST['parent_id'],
                'post_catalogue_id' => $id,
                'language_id' => 1,
                'image' => $_POST['image'] ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
                'table' => $payload,
                'pivot' => $payloadPivot
            ];

            $request = new PostCatalogueRequest($this->db);
            $validationResult = $request->store($data);
            if (isset($validationResult['success'])) {
                $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
                $result = $NestedSet->update($data, $id);

                if ($result) {
                    alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../nhom-bai-viet');
                } else {
                    alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-nhom-bai-viet/' . $id . '');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
                $data['dropDowns'] = $NestedSet->dropDown(
                    $condition = [
                        'tb1.id',
                        'tb1.parent_id',
                        'tb1.publish',
                        'tb1.image',
                        'tb1.depth',
                    ],
                    $join = [
                        [
                            'tb2.name', 
                            'tb2.canonical',
                        ]
                    ],
                    [],
                    'post_catalogue_id'
                );  
                $data['dropDowns'] = $data['dropDowns']['result'];
                $errors = $validationResult;
                $data['template'] = 'postCatalogue/store';
                $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $PostCatalogue = new PostCatalogue($this->db);
            $postCatalogue = $PostCatalogue->loadPostCatalogue($id);

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
                $data = [],
                'post_catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];
            $data['postCatalogue'] = $postCatalogue;

            $data['method'] = 'sua-nhom-bai-viet/' . $id . '';

            $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['update'];
            $data['template'] = 'postCatalogue/store';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $result = $NestedSet->softDelete($id);
            if ($result) {
                alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-nhom-bai-viet/' . $id . '');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $PostCatalogue = new PostCatalogue($this->db);
            $data['postCatalogue'] = $PostCatalogue->loadPostCatalogue($id);

            $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['delete'];
            $data['template'] = 'postCatalogue/destroy';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $result = $NestedSet->delete($id);
            if ($result) {
                alertSuccess('Thành công', 'Xoá bản ghi thành công', '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-nhom-bai-viet/' . $id . '');
            }
        }
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $NestedSet = new NestedSet($this->db, 'post_catalogues', 'post_catalogue_language');
            $result = $NestedSet->restore($id);
            if ($result) {
                alertSuccess('Thành công', 'Hoàn tác bản ghi thành công', '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../nhom-bai-viet');
            }
        }
    }

    private function getLanguage()
    {
        return 1;
    }
}
