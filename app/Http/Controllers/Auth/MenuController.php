<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MenuRequest;
use App\Repositories\Auth\MenuRepository;
use App\Transformers\Auth\MenuListTransformer;

class MenuController extends Controller
{

    protected $menuRepository;

    function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }


    /**
     * 菜单所有列表加菜单树形结构
     *
     * @param MenuRequest $request
     * @return mixed
     */
    public function getList(MenuRequest $request){
        $data = $this->menuRepository->getList($request);
        $menu = $this->menuRepository->getMenu();
        $this->response->addMeta(["menu" => $menu]);
        return $this->response->send($data);
    }

    /**
     * 删除菜单
     *
     * @param MenuRequest $request
     * @return mixed
     */
    public function postDel(MenuRequest $request) {
        $this->menuRepository->postDel($request);
        return $this->response->send();
    }

    /**
     * 菜单树形结构
     *
     * @return mixed
     */
    public function getMenuList(){
        $data = $this->menuRepository->getMenu();
        $obj = new MenuListTransformer();
        $this->response->setTransformer($obj);
        return $this->response->send($data);
    }






}
