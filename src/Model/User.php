<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Class User
 * @package App\Model
 * @mixin Builder
 */
class User extends Model
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
     * @return User|null
     */
    public static function getById(int $id) : User | null
    {
        return self::find($id);
    }

    /**
     * @return User
     */
    public static function getBySession() : User
    {
        if (isset($_SESSION['login'])) {
            $user = self::getByName($_SESSION['login']);
        }

        return isset($user) ? $user : new User();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public static function getByEmail(string $email) : User | null
    {
        return self::where('email', $email)->first();
    }

    /**
     * @param string $name
     * @return User|null
     */
    public static function getByName(string $name) : User | null
    {
        return self::where('name', $name)->first();
    }

    /**
     * @param int $group_id
     * @return Group|null
     */
    public static function getGroup(int $group_id) : Group | null
    {
        return Group::where('id', $group_id)->first();
    }

    /**
     * @param int $user_id
     * @return bool
     */
    public static function subscribe(int $user_id) : bool
    {
        return self::where('id', $user_id)->update(['subscribed' => 1]);
    }

    /**
     * @param int $user_id
     * @return bool
     */
    public static function unsubscribe(int $user_id) : bool
    {
        return self::where('id', $user_id)->update(['subscribed' => 0]);
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
