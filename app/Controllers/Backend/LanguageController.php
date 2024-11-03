<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\Language;
use App\Models\LanguageCatalogue;
use App\Models\Base;
use App\Requests\LanguageRequest;

class LanguageController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->BaseModel = new Base($db);
    }
    public function index()
    {
        $Language = new Language($this->db);
        $data['perPage'] = $_GET['perpage'] ?? 10;
        $data['page'] = $_GET['page'] ?? 1;
        $data['status'] = $_GET['status'] ?? -1;
        $data['keyword'] = $_GET['keyword'] ?? '';
        $data['flag'] = $_GET['flag'] ?? 1;
        $flag = $data['flag'] === '2';

        $data['languages'] = $Language->pagination('languages', $data['perPage'], $data['page'], $data['keyword'], $data['status'], $flag);

        $data['total_pages'] = $data['languages']['total_pages'];
        $data['current_page'] = $data['languages']['current_page'];

        $data['template'] = 'language/index';
        $data['title'] = $GLOBALS['sub']['language']['title']['index'];
        $this->view('admin/index', ['data' => $data]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['title'] = $GLOBALS['sub']['language']['title']['create'];
            $data['template'] = 'language/store';
            $this->view('admin/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $request = new LanguageRequest($this->db);
            $validationResult = $request->store($data);

            if (isset($validationResult['success'])) {
                $Language = new Language($this->db, $data['name'], $data['canonical'], $data['image']);
                $result = $Language->save();

                if ($result) {
                    alertSuccess('Thành công', "Tạo bản ghi thành công", 'ngon-ngu');
                } else {
                    alertError('Thất bại', 'Tạo bản ghi thất bại', 'tao-ngon-ngu');
                }
            } else {
                $errors = $validationResult;
                $data['template'] = 'language/store';
                $data['title'] = $GLOBALS['sub']['language']['title']['create'];
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
            $Language = new Language($this->db, $name, $canonical, $description);
            $result = $Language->update($id);
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../ngon-ngu');
            } else {
                alertError('Thất bại', 'Cập nhật ghi thất bại', '../sua-ngon-ngu/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['language'] = $this->BaseModel->find($id, 'languages');
            $data['title'] = $GLOBALS['sub']['language']['title']['update'];
            $data['template'] = 'language/update';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function softdelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->BaseModel->softDelete($id, 'languages');
            if ($result) {
                alertSuccess('Thành công', "Cập nhật bản ghi thành công", '../ngon-ngu');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-ngon-ngu/'.$id.'');
            }
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
            $data['language'] = $this->BaseModel->find($id, 'languages');

            $Language = new Language($this->db);
            
            $data['title'] = $GLOBALS['sub']['language']['title']['delete'];
            $data['template'] = 'language/destroy';
            $this->view('admin/index', ['data' => $data]);
        } 
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->delete($id, 'languages');
            if ($result) {
                alertSuccess('Thành công', "Xoá bản ghi thành công", '../ngon-ngu');
            } else {
                alertError('Thất bại', 'Xoá bản ghi thất bại', '../xoa-ngon-ngu/'.$id.'');
            }
        } 
    }

    public function restore($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($id))) {
            $result = $this->BaseModel->restore($id, 'languages');
            if ($result) {
                alertSuccess('Thành công', "Hoàn tác bản ghi thành công", '../ngon-ngu');
            } else {
                alertError('Thất bại', 'Hoàn tác bản ghi thất bại', '../ngon-ngu');
            }
        } 
    }
}
