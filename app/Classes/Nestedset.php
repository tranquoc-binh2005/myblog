<?php
namespace App\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Nestedsetbie
{
    function __construct($params = null)
    {
        $this->params = $params;
        $this->checked = null;
        $this->data = null;
        $this->count = 0;
        $this->count_level = 0;
        $this->lft = null;
        $this->rgt = null;
        $this->level = null;
    }

    public function Get()
    {
        $foreignkey = isset($this->params['foreignkey']) ? $this->params['foreignkey'] : 'post_catalogue_id';
        $moduleExtract = explode('_', $this->params['table']);
        $result = DB::table($this->params['table'] . ' as tb1')
            ->select('tb1.id', 'tb2.name', 'tb1.parent_id', 'tb1.lft', 'tb1.rgt', 'tb1.level', 'tb1.order')
            ->join($moduleExtract[0] . '_catalogue_language as tb2', 'tb1.id', '=', 'tb2.' . $foreignkey . '')
            ->where('tb2.language_id', '=', $this->params['language_id'])
            ->whereNull('tb1.deleted_at')
            ->orderBy('tb1.lft', 'asc')
            ->get()
            ->toArray();
        $this->data = $result;
    }

    public function Set()
    {
        if (isset($this->data) && is_array($this->data)) {
            $arr = null;
            foreach ($this->data as $key => $val) {
                $arr[$val->id][$val->parent_id] = 1;
                $arr[$val->parent_id][$val->id] = 1;
            }
            return $arr;
        }
    }

    public function Recursive($start = 0, $arr = null)
    {
        $this->lft[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;
        if (isset($arr) && is_array($arr)) {
            foreach ($arr as $key => $val) {
                if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->rgt[$start] = ++$this->count;
    }

    public function Action()
    {
        if (isset($this->level) && is_array($this->level) && isset($this->lft) && is_array($this->lft) && isset($this->rgt) && is_array($this->rgt)) {
            $data = null;
            foreach ($this->level as $key => $val) {
                if ($key == 0) {
                    continue;
                }
                $data[] = [
                    'id' => $key,
                    'level' => $val,
                    'lft' => $this->lft[$key],
                    'rgt' => $this->rgt[$key],
                    'user_id' => Auth::id(),
                ];
            }
            if (isset($data) && is_array($data) && count($data)) {
                DB::table($this->params['table'])->upsert($data, 'id', ['level', 'lft', 'rgt']);
            }
        }
    }

    public function Dropdown($param = null)
    {
        $this->get();
        if (isset($this->data) && is_array($this->data)) {
            $temp = null;
            $temp[0] = isset($param['text']) && !empty($param['text']) ? $param['text'] : '[Root]';
            foreach ($this->data as $key => $val) {
                $temp[$val->id] = str_repeat('|-----', $val->level > 0 ? $val->level - 1 : 0) . $val->name;
            }
            return $temp;
        }
    }
}
