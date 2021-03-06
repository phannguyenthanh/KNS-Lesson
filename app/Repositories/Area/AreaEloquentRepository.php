<?php

namespace App\Repositories\Area;

use App\Models\Area;
use App\Repositories\EloquentRepository;

class AreaEloquentRepository extends EloquentRepository implements AreaRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Area::class;
    }

    /**
     * Get pages
     * @author Minhpt
     * @date 17/04/2018
     * @return mixed
     */
    public function getPages($records, $search = null)
    {
        $total = !is_null($search) ? count($this->_model->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
            $q->orWhere('description', 'like', '%' . $search . '%');
        })->get()) : count($this->_model->get());
        return ceil($total / $records);
    }

    /**
     * Get all
     * @author Minhpt
     * @date 17/04/2018
     * @return mixed
     */
    public function getObjects($records, $search = null)
    {
        return is_null($search) ? $this->_model->paginate($records)->items() : $this->_model->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
            $q->orWhere('description', 'like', '%' . $search . '%');
        })->paginate($records)->items();
    }
}