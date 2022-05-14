<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Class Setting
 * @package App\Model
 * @mixin Builder
 */
class Setting extends Model
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
     * @param string $name
     * @return Setting|null
     */
    public static function getByName(string $name) : Setting | null
    {
        return self::where('name', $name)->first();
    }

    /**
     * @param int $id
     * @param mixed $value
     * @return bool
     */
    public static function updateSetting(int $id, mixed $value) : bool
    {
        return self::where('id', $id)->update(['value' => $value]);
    }
}
