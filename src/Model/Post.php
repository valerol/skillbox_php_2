<?php
namespace App\Model;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Post
 * @package App\Model
 * @mixin Builder
 */
class Post extends Model
{
    protected $guarded = [];

    /**
     * @return Collection
     */
    public static function getAll() : Collection
    {
        return self::get();
    }

    /**
     * @param int $page
     * @param int $per_page
     * @param array $condition
     * @return Collection
     */
    public static function getPaginatedByCond(
        int $page,
        int $per_page,
        array $condition = []
    ) : Collection
    {
        return self::where($condition)->orderByDesc('created_at')
            ->skip($per_page * ($page - 1))->take($per_page)->get();
    }

    /**
     * @param array $condition
     * @return int
     */
    public static function countByCond(array $condition = []) : int
    {
        return self::where($condition)->count();
    }

    /**
     * @param int $id
     * @return Post
     */
    public static function getById(int $id) : Post | null
    {
        return self::find($id);
    }

    /**
     * @param array $data
     * @return int
     */
    public static function addNewId(array $data) : int
    {
        return self::create($data)->id;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function removeById(int $id) : bool
    {
        return self::destroy($id);
    }
}
