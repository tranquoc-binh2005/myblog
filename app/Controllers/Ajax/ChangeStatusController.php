<?php
namespace App\Controllers\Ajax;

class ChangeStatusController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function changeStatus()
    {
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $filed = $_POST['filed'];
        $column = $_POST['column'];
        $value = $_POST['value'];

        $newValue = $value == 1 ? 2 : 1;

        $model = 'App\Models\Base';
        $BaseModel = new $model($this->db);
        $result = $BaseModel->changeStatus($id, $filed, $column, $newValue);

        // echo $result; die();
        if ($result) {
            return json_encode([
                'status' => 'success',
                'message' => 'Trạng thái đã được cập nhật thành công!',
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái.',
            ]);
        }
    }
    public function changeStatusAll()
    {
        header('Content-Type: application/json');

        $ids = isset($_POST['ids']) ? (array) $_POST['ids'] : [];
        $option = isset($_POST['option']) ? $_POST['option'] : [];

        if (empty($ids) || empty($option)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Thiếu thông tin cần thiết!',
            ]);
            return;
        }

        $newValue = $option['value'] == 1 ? 2 : 1;

        $model = 'App\Models\Base';
        $BaseModel = new $model($this->db);
        $result = $BaseModel->changeStatusAlls($ids, $option['field'], $option['column'], $newValue);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Trạng thái đã được cập nhật thành công!',
                'new_value' => $newValue,
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái.',
            ]);
        }
    }
}
