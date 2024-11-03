<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\User;
use App\Models\UserCatalogue;
use App\Models\Base;
use App\Requests\UserRequest;

class UserController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $User = new User($this->db);
        $data['perPage'] = $_GET['perpage'] ?? 10;
        $data['page'] = $_GET['page'] ?? 1;
        $data['status'] = $_GET['status'] ?? -1;
        $data['keyword'] = $_GET['keyword'] ?? '';
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'] === '2';

        $data['users'] = $User->pagination('user', $data['perPage'], $data['page'], $data['keyword'], $data['status'], $flag);
        foreach ($data['users']['data'] as &$user) {
            $user['userCatalogue_name'] = $User->loadUserCatalogue_name($user['userCatalogue_id']);
        }
        unset($user);

        $data['total_pages'] = $data['users']['total_pages'];
        $data['current_page'] = $data['users']['current_page'];

        $data['template'] = 'user/index';
        $data['title'] = $GLOBALS['sub']['user']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['user']['title']['create'];
            $data['userCatalogues'] = $this->BaseModel->all('user_catalogue');
            $data['template'] = 'user/store';
            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $request = new UserRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $User = new User($this->db, $data['userCatalogue_id'], $data['name'], $data['description'], $data['image'], $data['address'], $data['phone'], $data['email'], $data['password']);
                $result = $User->save();

                if ($result) {
                    alertSuccess('Thành công', "Tạo bản ghi thành công", 'thanh-vien');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-thanh-vien');
                }
            } else {
                $errors = $validationResult;
                $data['template'] = 'user/store';
                $data['title'] = $GLOBALS['sub']['user']['title']['create'];
                $data['userCatalogues'] = $this->BaseModel->all('user_catalogue');
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
            $User = new User($this->db, $name, $canonical, $description);
            $result = $User->update($id);
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../thanh-vien');
            } else {
                alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-thanh-vien/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['user'] = $this->BaseModel->find($id, 'user');
            $data['title'] = $GLOBALS['sub']['user']['title']['update'];
            $data['template'] = 'user/update';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->BaseModel->softDelete($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../thanh-vien');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-thanh-vien/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['user'] = $this->BaseModel->find($id, 'user');

            $User = new User($this->db);
            $data['user']['userCatalogue_name'] = $User->loadUserCatalogue_name($data['user']['userCatalogue_id']);;
            
            $data['title'] = $GLOBALS['sub']['user']['title']['delete'];
            $data['template'] = 'user/destroy';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->delete($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Xoá bản ghi thành công", '../thanh-vien');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-thanh-vien/'.$id.'');
            }
        } 
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->restore($id, 'user');
            if ($result) {
                alertSuccess('Thành công', "Hoàn tác bản ghi thành công", '../thanh-vien');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../thanh-vien');
            }
        } 
    }
}
