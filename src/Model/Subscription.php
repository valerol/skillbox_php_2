<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exception\ApplicationException;
use Illuminate\Support\Collection;

/**
 * Class Subscription
 * @package App\Model
 */
class Subscription extends Model
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
     * @param string $nonce
     * @return Subscription|null
     */
    public static function getByNonce(string $nonce) : Subscription | null
    {
        return self::where('nonce', $nonce)->first();
    }

    /**
     * @param string $email
     * @return Subscription|null
     */
    public static function getByEmail(string $email) : Subscription | null
    {
        return self::where('email', $email)->first();
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getEmailById(int $id) : string
    {
        return self::where('id', $id)->first()->email;
    }

    /**
     * @param string $email
     * @return Subscription
     * @throws ApplicationException
     */
    public static function addNew(string $email) : Subscription
    {

        if (empty(Subscription::where('email', $email)->first())) {
            return Subscription::create([
                'email' => $email,
                'nonce' => hash('md5', random_bytes(4))
            ]);
        } else {
            throw new ApplicationException('Вы уже подписаны');
        }
    }

    /**
     * @param string $email
     * @return int
     */
    public static function removeByEmail(string $email) : int
    {
        return self::where('email', $email)->delete();
    }

    /**
     * @param int $id
     * @return int
     */
    public static function removeById(int $id) : int
    {
        return self::destroy($id);
    }
}
