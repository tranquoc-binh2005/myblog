<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\Post;
use App\Models\NestedSet;
use App\Models\Base;
use App\Models\Product;
use App\Requests\ProductRequest;

class ProductController extends Controller
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

        $NestedSet = new NestedSet($this->db, 'product', 'product_language');
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
            'product_id'
        );
        $Product = new Product($this->db);

        if(isset($data['dropDowns']['result']) && (is_array($data['dropDowns']['result']))){
            foreach ($data['dropDowns']['result'] as $key => &$val) {
                $data['dropDowns']['result'][$key]['catalogues'] = $Product->loadCatalogue($val['id']);
            }
        }

        $data['total_pages'] = $data['dropDowns']['totalPage'];
        $data['current_page'] = $data['dropDowns']['currentPage'];
        $data['dropDowns'] = $data['dropDowns']['result'];

        $data['template'] = 'product/index';
        $data['title'] = $GLOBALS['sub']['product']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['product']['title']['create'];
            $data['template'] = 'product/store';

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
                [],
                'catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'xu-ly-tao-san-pham';

            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'sale' => $_POST['sale'],
                'description' => $_POST['description'] ?? null,
                'content' => $_POST['content'] ?? null,
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'canonical' => $_POST['canonical'],
                'parent_id' => $_POST['parent_id'],
                'catalogue' => $_POST['catalogue'],
                'image' => $_POST['image'] ?? null,
                'album' => $_POST['album'] ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];

            $data['language_id'] = $this->getLanguage();

            $request = new ProductRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $Product = new Product(
                    $this->db,
                    $data['parent_id'], 
                    $data['image'], 
                    json_encode($data['album']), 
                    $data['publish'], 
                    $data['follow'], 
                    $data['price'], 
                    $data['sale'], 
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
                $result = $Product->save('product', 'product_language');
                if ($result) {
                    alertSuccess('Thành công', 'Tạo bản ghi thành công', 'san-pham');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-san-pham');
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
                        'tb2.name'
                    ],
                    [],
                    'catalogue_id'
                );   
                $data['dropDowns'] = $data['dropDowns']['result'];

                $errors = $validationResult;
                $data['template'] = 'product/store';
                $data['title'] = $GLOBALS['sub']['product']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        } else {
            echo 'Phương thức không hợp lệ.';
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'sale' => $_POST['sale'],
                'description' => $_POST['description'] ?? null,
                'content' => $_POST['content'] ?? null,
                'meta_title' => $_POST['meta_title'] ?? null,
                'meta_keyword' => $_POST['meta_keyword'] ?? null,
                'meta_description' => $_POST['meta_description'] ?? null,
                'canonical' => $_POST['canonical'],
                'parent_id' => $_POST['parent_id'],
                'catalogue' => $_POST['catalogue'],
                'image' => $_POST['image'] ?? null,
                'album' => $_POST['album'] ?? null,
                'publish' => $_POST['publish'] ?? null,
                'follow' => $_POST['follow'] ?? null,
            ];

            $data['language_id'] = $this->getLanguage();

            $request = new ProductRequest($this->db);
            $validationResult = $request->store($data);
            if (isset($validationResult['success'])) {
                $Product = new Product(
                    $this->db,
                    $data['parent_id'], 
                    $data['image'], 
                    json_encode($data['album']), 
                    $data['publish'], 
                    $data['follow'], 
                    $data['price'], 
                    $data['sale'], 
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
                $result = $Product->update('product', 'product_language', $id);

                if ($result) {
                    alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../san-pham');
                } else {
                    alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-san-pham/' . $id . '');
                }
            } else {
                $NestedSet = new NestedSet($this->db, 'product', 'product_language');
                $data['dropDowns'] = $NestedSet->dropDown(
                    $condition = [],
                    $join = ['tb2.name'],
                    $payload = [
                        'flag' => 0,
                    ],
                );
                $errors = $validationResult;
                $data['template'] = 'product/store';
                $data['title'] = $GLOBALS['sub']['product']['title']['create'];
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $condition = [
                'tb1.image',
                'tb1.id',
                'tb1.album',
                'tb1.price',
                'tb1.sale',
                'tb1.parent_id',
            ];
            $join = [
                'tb2.name', 
                'tb2.description', 
                'tb2.content', 
                'tb2.canonical', 
                'tb2.meta_title', 
                'tb2.meta_keyword', 
                'tb2.meta_description', 
                'tb3.catalogue_id'
            ];
            $Product = new Product($this->db);
            $data['product'] = $Product->loadProduct($condition,$join, $id);

            $data['catalogue'] = $data['product']['catalogue_id'];
            $data['product'] = $data['product']['result'][0];
            $data['product']['album'] = json_decode($data['product']['album'], true);
            // print_r($data); die();

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
                [],
                'catalogue_id'
            );   
            $data['dropDowns'] = $data['dropDowns']['result'];

            $data['method'] = 'sua-san-pham/' . $id . '';

            $data['title'] = $GLOBALS['sub']['product']['title']['update'];
            $data['template'] = 'product/store';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Base = new Base($this->db);
            $result = $Base->softDelete($id, 'product');
            if ($result) {
                alertSuccess('Thành công', 'Cập nhật bản ghi thành công', '../san-pham');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-san-pham/' . $id . '');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Product = new Product($this->db);
            $data['product'] = $Product->findProduct($id);

            $data['title'] = $GLOBALS['sub']['product']['title']['delete'];
            $data['template'] = 'product/destroy';
            $this->view('admin/index', ['data' => $data]);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $Base = new Base($this->db);
            $result = $Base->delete($id, 'product');
            if ($result) {
                alertSuccess('Thành công', 'Xoá bản ghi thành công', '../san-pham');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-san-pham/' . $id . '');
            }
        }
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($id)) {
            $Base = new Base($this->db);
            $result = $Base->restore($id, 'product');
            if ($result) {
                alertSuccess('Thành công', 'Hoàn tác bản ghi thành công', '../san-pham');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../san-pham');
            }
        }
    }

    private function getLanguage()
    {
        return 1;
    }
}
