<?php
namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    public function all(array $relations = []) {
        return $this->model->with($relations)->get();
    }
    public function find($id, array $relations = []) {
        return $this->model->with($relations)->find($id);
    }
    public function create(array $data) {
        return $this->model->create($data);
    }
    public function update($id, array $data) {
        return $this->model->where('id',$id)->update($data);
    }
    public function delete($id) {
        return $this->model->where('id',$id)->delete();
    }
}
