<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\Catalogue;
use App\Models\NestedSet;
use App\Models\Base;
use App\Requests\CatalogueRequest;

class CatalogueController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $Catalogue = new Catalogue($this->db);
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'];

        $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
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
                ]
            ],
            $data = [
                'publish' => $_GET['status'] ?? -1,
                'flag' => $flag,
                'keyword' => $_GET['keyword'] ?? '',
                'page' => $_GET['page'] ?? 1,
                'perPage' => $_GET['perpage'] ?? 10,
            ],
            'catalogue_id'
        );

        $data['total_pages'] = $data['dropDowns']['totalPage'];
        $data['current_page'] = $data['dropDowns']['currentPage'];
        $data['dropDowns'] = $data['dropDowns']['result'];

        $data['template'] = 'catalogue/index';
        $data['title'] = $GLOBALS['sub']['catalogue']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['catalogue']['title']['create'];
            $data['template'] = 'catalogue/store';

            $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
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
                    ]
                ],
                [],
                'catalogue_id'
            ); 
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'xu-ly-tao-danh-muc-code';

            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'parent_id' => $_POST['parent_id'],
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];
            $data['field'] = ['parent_id', 'lft', 'rgt', 'depth', 'publish', 'follow', 'user_id', 'image'];
            $data['primary'] = ['catalogue_id', 'language_id'];
            $request = new CatalogueRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
                $result = $NestedSet->insert($data, $data['parent_id'], $data['primary']);

                if ($result) {
                    alertSuccess('Thành công', 'Tạo bản ghi thành công', 'danh-muc-code');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-danh-muc-code');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
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
                        ]
                    ],
                    [],
                    'catalogue_id'
                ); 
                $data['dropDowns'] = $data['dropDowns']['result'];
                $errors = $validationResult;
                $data['template'] = 'catalogue/store';
                $data['title'] = $GLOBALS['sub']['catalogue']['title']['create'];
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
            ];
            $payloadPivot = [
                'name',
                'meta_title', 
                'meta_keyword', 
                'meta_description', 
                'catalogue_id',
                'language_id',
            ]; 
            $data = [
                'name' => $_POST['name'],
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'parent_id' => $_POST['parent_id'],
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
                'table' => $payload,
                'pivot' => $payloadPivot
            ];

            $request = new CatalogueRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
                $result = $NestedSet->update($data, $id, ['id', 'catalogue_id']);

                if ($result) {
                    alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../danh-muc-code');
                } else {
                    alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-danh-muc-code/' . $id . '');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
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
                    'catalogue_id'
                );  
                $data['dropDowns'] = $data['dropDowns']['result'];
                $errors = $validationResult;
                $data['template'] = 'catalogue/store';
                $data['title'] = $GLOBALS['sub']['catalogue']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Catalogue = new Catalogue($this->db);
            $Catalogue = $Catalogue->loadCatalogue($id);

            $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
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
                'catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];
            $data['catalogue'] = $Catalogue;

            $data['method'] = 'sua-danh-muc-code/' . $id . '';

            $data['title'] = $GLOBALS['sub']['catalogue']['title']['update'];
            $data['template'] = 'catalogue/store';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
            $result = $NestedSet->softDelete($id);
            if ($result) {
                alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../danh-muc-code');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-danh-muc-code/' . $id . '');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Catalogue = new Catalogue($this->db);
            $data['catalogue'] = $Catalogue->loadCatalogue($id);

            $data['title'] = $GLOBALS['sub']['catalogue']['title']['delete'];
            $data['template'] = 'catalogue/destroy';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
            $result = $NestedSet->delete($id);
            if ($result) {
                alertSuccess('Thành công', 'Xoá bản ghi thành công', '../danh-muc-code');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-danh-muc-code/' . $id . '');
            }
        }
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $NestedSet = new NestedSet($this->db, 'catalogue', 'catalogue_language');
            $result = $NestedSet->restore($id);
            if ($result) {
                alertSuccess('Thành công', 'Hoàn tác bản ghi thành công', '../danh-muc-code');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../danh-muc-code');
            }
        }
    }

    private function getLanguage()
    {
        return 1;
    }
}
