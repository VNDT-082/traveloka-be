<?php

namespace App\Services;

use App\Repositories\repository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// use Exception;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Validator;
// use InvalidArgumentException;

abstract class BaseService implements IBaseService
{
    /**
     * @var $repository
     */
    protected $repository;

    /**
     * PostService constructor.
     *
     * @param repository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function count()
    {
        return $this->repository->count();
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function createMultiple(array $data)
    {
        return $this->repository->createMultiple($data);
    }

    public function delete()
    {
        return $this->repository->delete();
    }

    public function deleteById($id)
    {
        return $this->repository->deleteById($id);
    }

    public function deleteMultipleById(array $ids)
    {
        return $this->repository->deleteMultipleById($ids);
    }

    public function first()
    {
        return $this->repository->first();
    }

    public function get()
    {
        return $this->repository->get();
    }
    public function paginate($page)
    {
        return $this->repository->paginate($page);
    }

    public function getById($id)
    {
        try {
            return $this->repository->getById($id);
        } catch (ModelNotFoundException $ex) {
            return null;
        }
    }

    public function limit($limit)
    {
        return $this->repository->limit($limit);
    }

    public function orderBy($column, $value)
    {
        return $this->repository->orderBy($column, $value);
    }

    public function updateById($id, array $data)
    {
        return $this->repository->updateById($id, $data);
    }

    public function where($column, $value, $operator = '=')
    {
        return $this->repository->where($column, $value, $operator = '=');
    }

    public function whereIn($column, $value)
    {
        return $this->repository->whereIn($column, $value);
    }

    public function with($relations)
    {
        return $this->repository->with($relations);
    }



    // /**
    //  * Delete post by id.
    //  *
    //  * @param $id
    //  * @return String
    //  */
    // public function deleteById($id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $post = $this->repository->delete($id);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::info($e->getMessage());

    //         throw new InvalidArgumentException('Unable to delete post data');
    //     }

    //     DB::commit();

    //     return $post;

    // }

    // /**
    //  * Get all post.
    //  *
    //  * @return String
    //  */
    // public function getAll()
    // {
    //     return $this->repository->all();
    // }

    // /**
    //  * Get post by id.
    //  *
    //  * @param $id
    //  * @return String
    //  */
    // public function getById($id)
    // {
    //     return $this->repository->getById($id);
    // }

    // /**
    //  * Update post data
    //  * Store to DB if there are no errors.
    //  *
    //  * @param array $data
    //  * @return String
    //  */
    // public function updateById($id,array $data)
    // {
    //     $validator = Validator::make($data, [
    //         'title' => 'bail|min:2',
    //         'description' => 'bail|max:255'
    //     ]);

    //     if ($validator->fails()) {
    //         throw new InvalidArgumentException($validator->errors()->first());
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $post = $this->repository->update($data, $id);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::info($e->getMessage());

    //         throw new InvalidArgumentException('Unable to update post data');
    //     }

    //     DB::commit();

    //     return $post;

    // }

    // /**
    //  * Validate post data.
    //  * Store to DB if there are no errors.
    //  *
    //  * @param array $data
    //  * @return String
    //  */
    // public function savePostData($data)
    // {
    //     $validator = Validator::make($data, [
    //         'title' => 'required',
    //         'description' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         throw new InvalidArgumentException($validator->errors()->first());
    //     }

    //     $result = $this->repository->save($data);

    //     return $result;
    // }

}
