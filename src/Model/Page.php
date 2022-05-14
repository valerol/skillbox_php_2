<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Page
 * @package App\Model
 */
class Page extends Model
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
    public static function getPaginatedByCond(int $page, int $per_page, array $condition = []) : Collection
    {
        return self::where($condition)->orderByDesc('created_at')->skip($per_page * ($page - 1))->take($per_page)->get();
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
     * @return Page|null
     */
    public static function getById(int $id) : Page | null
    {
        return self::find($id);
    }

    /**
     * @param string $path
     * @return Page|null
     */
    public static function getByPath(string $path) : Page | null
    {
        return self::where('path', $path)->first();
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
