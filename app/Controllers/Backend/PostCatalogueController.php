<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\PostCatalogue;
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
        $User = new PostCatalogue($this->db);
        $data['perPage'] = $_GET['perpage'] ?? 10;
        $data['page'] = $_GET['page'] ?? 1;
        $data['status'] = $_GET['status'] ?? -1;
        $data['keyword'] = $_GET['keyword'] ?? '';
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'] === '2';

        $data['total_pages'] = $data['postCatalogue']['total_pages'];
        $data['current_page'] = $data['postCatalogue']['current_page'];

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
            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $name,
                'description' => $description,
                'content' => $content,
                'meta_title' => $meta_title,
                'meta_keyword' => $meta_keyword,
                'meta_description' => $meta_description,
                'canonical' => $canonical,
                'parent_id' => $parent_id,
                'image' => $image,
                'publish' => $publish,
                'follow' => $follow,
            ];

            $request = new PostCatalogueRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                // $User = new PostCatalogue($this->db, $data['postCatalogue_id'], $data['name'], $data['description'], $data['image'], $data['address'], $data['phone'], $data['email'], $data['password']);
                // $result = $User->save();

                if ($result) {
                    alertSuccess('Thành công', "Tạo bản ghi thành công", 'nhom-bai-viet');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-nhom-bai-viet');
                }
            } else {
                $errors = $validationResult;
                $data['template'] = 'postCatalogue/store';
                $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['create'];
                $data['postCatalogues'] = $this->BaseModel->all('user_catalogue');
                $this->view('admin/index', ['errors' => $errors, 'data' => $data]);
            }
        } else {
            echo 'Phương thức không hợp lệ.';
        }
    }

    function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $canonical = $_POST['canonical'];
            $description = $_POST['description'];
            $User = new PostCatalogue($this->db, $name, $canonical, $description);
            $result = $User->update($id);
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-nhom-bai-viet/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['post'] = $this->BaseModel->find($id, 'user');
            $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['update'];
            $data['template'] = 'postCatalogue/update';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->BaseModel->softDelete($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-nhom-bai-viet/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['post'] = $this->BaseModel->find($id, 'user');

            $User = new PostCatalogue($this->db);
            $data['post']['postCatalogue_name'] = $User->loadUserCatalogue_name($data['post']['postCatalogue_id']);;
            
            $data['title'] = $GLOBALS['sub']['postCatalogue']['title']['delete'];
            $data['template'] = 'postCatalogue/destroy';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->delete($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Xoá bản ghi thành công", '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-nhom-bai-viet/'.$id.'');
            }
        } 
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->restore($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Hoàn tác bản ghi thành công", '../nhom-bai-viet');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../nhom-bai-viet');
            }
        } 
    }
}
