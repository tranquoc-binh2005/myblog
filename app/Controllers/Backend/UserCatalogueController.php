<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\UserCatalogue;
use App\Models\Base;
use App\Requests\RoleRequest;

class UserCatalogueController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $UserCatalogue = new UserCatalogue($this->db);
        $data['perPage'] = $_GET['perpage'] ?? 10;
        $data['page'] = $_GET['page'] ?? 1;
        $data['status'] = $_GET['status'] ?? -1;
        $data['keyword'] = $_GET['keyword'] ?? '';
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'] === '2';

        $data['userCatalogues'] = $UserCatalogue->pagination(
            'user_catalogue', 
            $data['perPage'], 
            $data['page'], 
            $data['keyword'], 
            $data['status'], 
            $flag
        );
        
        $data['total_pages'] = $data['userCatalogues']['total_pages'];
        $data['current_page'] = $data['userCatalogues']['current_page'];

        $data['template'] = 'userCatalogue/index';
        $data['title'] = $GLOBALS['sub']['roles']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        $data['title'] = $GLOBALS['sub']['roles']['title']['create'];
        $data['template'] = 'userCatalogue/store';
        $this->view('admin/index', ['data' => $data]);
    }

    public function handleStore()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $validationResult = RoleRequest::store($data);

            if (isset($validationResult['success'])) {
                $UserCatalogue = new UserCatalogue($this->db, $data['name'], $data['canonical'], $data['description']);
                $result = $UserCatalogue->save();

                if ($result) {
                    alertSuccess('Thành công', "Tạo bản ghi thành công", 'nhom-vai-tro');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-vai-tro');
                }
            } else {
                $errors = $validationResult;
                $data['template'] = 'userCatalogue/store';
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
            $UserCatalogue = new UserCatalogue($this->db, $name, $canonical, $description);
            $result = $UserCatalogue->update($id);
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../nhom-vai-tro');
            } else {
                alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-vai-tro/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['user_catalogue'] = $this->BaseModel->find($id, 'user_catalogue');
            $data['title'] = $GLOBALS['sub']['roles']['title']['update'];
            $data['template'] = 'userCatalogue/update';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->BaseModel->softDelete($id, 'user_catalogue');
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../nhom-vai-tro');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-vai-tro/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['user_catalogue'] = $this->BaseModel->find($id, 'user_catalogue');
            $data['title'] = $GLOBALS['sub']['roles']['title']['delete'];
            $data['template'] = 'userCatalogue/destroy';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->delete($id, 'user_catalogue');
            if ($result) {
                alertSuccess('Thành công', "Xoá bản ghi thành công", '../nhom-vai-tro');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-vai-tro/'.$id.'');
            }
        } 
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->restore($id, 'user_catalogue');
            if ($result) {
                alertSuccess('Thành công', "Hoàn tác bản ghi thành công", '../nhom-vai-tro');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../nhom-vai-tro');
            }
        } 
    }
}
