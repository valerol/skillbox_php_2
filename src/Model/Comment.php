<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Comment
 * @package App\Model
 * @mixin Builder
 */
class Comment extends Model
{
    protected $guarded = [];

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
     * @return Comment|null
     */
    public static function getById(int $id) : Comment | null
    {
        return self::find($id);
    }

    /**
     * @param int $user_id
     * @return Collection
     */
    public static function getByUserId(int $user_id) : Collection
    {
        return self::where('user_id', $user_id)->get();
    }

    /**
     * @param int $post_id
     * @return Collection
     */
    public static function getByPostId(int $post_id) : Collection
    {
        return self::where('post_id', $post_id)->get();
    }

    private function prepareComments(int $post_id, User $user = null) : Collection
    {
        if (!$user->group_id) {
            return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.*', 'users.avatar', 'users.name')
                ->where(['post_id' => $post_id, 'comments.active' => 1])
                ->get();
        } elseif ($user->group_id < 5) {
            return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.*', 'users.avatar', 'users.name')
                ->where(['post_id' => $post_id], ['comments.active' => 1, 'user_id' => $user->id])
                ->get();
        } else {
            return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.*', 'users.avatar', 'users.name')
                ->where('post_id', $post_id)
                ->get();
        }
    }

    /**
     * @param int $post_id
     * @return Collection
     */
    public static function getByPostIdWithUser(int $post_id) : Collection
    {
        return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.*', 'users.avatar', 'users.name')
            ->where('post_id', $post_id)
            ->get();
    }

    /**
     * @param int $post_id
     * @return Collection
     */
    public static function getActiveByPostIdWithUser(int $post_id) : Collection
    {
        return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.*', 'users.avatar', 'users.name')
            ->where(['post_id' => $post_id, 'comments.active' => 1])
            ->get();
    }

    /**
     * @param int $post_id
     * @param int $user_id
     * @return Collection
     */
    public static function getActiveAndPersonalByPostIdWithUser(int $post_id, int $user_id) : Collection
    {
        return self::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.*', 'users.avatar', 'users.name')
            ->where(['post_id' => $post_id], ['comments.active' => 1, 'user_id' => $user_id])
            ->get();
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
