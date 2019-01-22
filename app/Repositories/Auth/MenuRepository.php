<?php

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
use App\Models\Auth\Menu;
use App\Models\Code;
use DB;

class MenuRepository extends BaseRepository{

    protected $model;

    public function __construct(Menu $menuModel)
    {
        $this->model = $menuModel;
    }

    /**
     * 菜单列表带父子集
     *
     * @return array
     */
    public function getMenuList(){
        $list1 = $this->model->getList();
        $list2 = $this->model->getList($list1->pluck('id')->all());
        $list3 = $this->model->getList($list2->pluck("id")->all());

        $list2Group = $list2->groupBy("pid")->toArray();

        $list3Group = $list3->groupBy("pid")->toArray();

        $data = [];
        foreach ($list1 as $value){
            $cur = $value->toArray();
            if(isset($list2Group[$value->id])){
                // 二级菜单
                $cur['children'] = $list2Group[$value->id];

                foreach ($cur['children'] as $key => &$child){
                    if(isset($list3Group[$child['id']])){
                        // 三级菜单
                        $child['children'] = $list3Group[$child['id']];
                    }
                }
            }
            $data[] = $cur;
        }

        return $data;
    }

    /**
     * 菜单所有列表
     *
     * @param $request
     * @return mixed
     */
    public function getList($request){
        $search = $request->input("s");
        $model = $this->model->where(function ($query) use ($search){
//            $query->orWhere('path', '<>', '/systems/config/menu');
            if(!empty($search)){
                $query->orWhere('name', 'like', '%' . $search . '%');
            }
        });
        return $this->usePage($model);
    }

    /**
     * 菜单树形结构
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMenu(){
        // 一级菜单
        $model1 = $this->model
                       ->select('pid', 'id', 'name AS p_name', DB::raw('CONCAT(id, pid) AS p_id'))
                       ->where('pid', 0);

        $model2 = $this->model->select('pid', 'id', 'name')->where('pid', 0);
        $model3 = DB::raw("({$model2->toSql()}) AS one")->getValue();
        $field = [
            'm.pid',
            'm.id',
            DB::raw('CONCAT(one.name, "|-", m.name) AS p_name'),
            DB::raw('CONCAT(m.pid, m.id) AS p_id'),
        ];
        // 二级菜单
        $model4 = DB::table('menus AS m')->select($field)
                                              ->join(DB::raw("{$model3}"),'m.pid', '=', 'one.id')
                                              ->mergeBindings($model2->getQuery());
        // 增加默认值
        $fields = [
            DB::raw('DISTINCT 0'),
            DB::raw(0),
            DB::raw("'无'"),
            DB::raw("'0'"),
        ];
        $model5 = $this->model->select($fields);

        // 联合一级菜单、二级菜单、默认值
        $model6 = $model1->unionAll($model4)->unionAll($model5);

        // 根据父菜单做排序
        $model7 = DB::raw("({$model6->toSql()}) AS e")->getValue();
        $eFields = [
            'e.pid',
            'e.id',
            'e.p_name',
        ];
        $model8 = DB::table(DB::raw("{$model7}"))->select($eFields)
                                                       ->orderBy('e.p_id','asc')
                                                       ->mergeBindings($model1->getQuery())
                                                       ->mergeBindings($model2->getQuery())
                                                       ->get();
        return $model8;

    }

    /**
     * 删除菜单
     *
     * @param $request
     * @return bool
     */
    public function postDel($request){
        $id = $request->input('id');
        // 查询是否有数据将数据id作为父级
        $res = $this->model->where('pid',$id)->first();
        if(!empty($res)){
            Code::setCode(Code::ERR_MENU_FIELD);
            return false;
        }
        $this->del($id);
    }




}