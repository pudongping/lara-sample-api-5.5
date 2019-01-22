<?php
/**
 * User: alex
 * Date: 2018-1-21
 * https://packalyst.com/packages/package/cyvelnet/laravel5-fractal
 */

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use App\Transformers\BaseTransformer;
use Fractal;

class Transformer{

    /**
     * add sparse fieldset
     *
     * @param $fields array|string 所需显示字段
     */
    public function fieldsets($fields){
        if(is_array($fields)){
            $fields = join(',', $fields);
        }
        Fractal::fieldsets([config('fractal.collection_key') => $fields]);
    }

    /**
     * Transform a collection of records
     *
     * @param $data Eloquent数据集
     * @param TransformerAbstract|null $transformer 对应Eloquent的transformer实例
     * @return mixed 经过transformer转换过的数据集
     * @throws \Exception
     */
    public function collection($data, TransformerAbstract $transformer = null){
        $transformer = $transformer ?: $this->fetchDefaultTransformer($data);
        return Fractal::collection($data, $transformer, config('fractal.collection_key'))->getArray();
    }

    /**
     * Transform a single record
     *
     * @param $data Eloquent单条数据
     * @param TransformerAbstract|null $transformer 对应Eloquent的transformer实例
     * @return mixed 经过transformer转换过的单条数据
     * @throws \Exception
     */
    public function item($data, TransformerAbstract $transformer = null){
        $transformer = $transformer ?: $this->fetchDefaultTransformer($data);
        return Fractal::item($data, $transformer, config("fractal.collection_key"))->getArray();
    }

    /**
     * 取默认的transformer
     * @param $data 数据集
     * @return BaseTransformer
     * @throws \Exception
     */
    protected function fetchDefaultTransformer($data){
        if(($data instanceof LengthAwarePaginator || $data instanceof Collection) && $data->isEmpty()){
            return new BaseTransformer();
        }
        $className = $this->getClassName($data);
        $transformer = $this->getDefaultTransformer($className);

        if(empty($transformer)){
            $transformer = str_replace('Models', 'Transformers', $className) . 'Transformer';
            if(!class_exists($transformer)){
                throw new \Exception('No transformer for ' . $className);
            }
        }

        return new $transformer;
    }

    protected function getDefaultTransformer($className){
        return config('fractal.transformers' . $className);
    }

    protected function getClassName($object){
        if($object instanceof LengthAwarePaginator || $object instanceof Collection){
            return get_class(array_first($object));
        }

        if(!is_string($object) && !is_object($object)){
            throw new \Exception('No transformer of' . $object . 'found');
        }

        return get_class($object);
    }




}