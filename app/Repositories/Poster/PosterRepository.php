<?php

namespace App\Repositories\Poster;

use App\Models\Poster_Model;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class PosterRepository extends BaseRepository implements IPosterRepository
{
    public function __construct(Poster_Model $model)
    {
        parent::__construct($model);
    }
    public function getOneById($id)
    {
        return $this->model::where('id', '=', $id)->first();
    }
    public function getOneByGitCode($giftCode)
    {
        return $this->model->where('GiftCode', '=', $giftCode)->first(); //::where('GiftCode', '<>', null)

    }
    public function getAllHaveGitCode()
    {
        return $this->model->where('HaveGitCode', '=', 1)
            ->where('PosterIsUse', '=', 1)
            ->where('EndDate', '>', Carbon::now())
            ->get();
    }
}
