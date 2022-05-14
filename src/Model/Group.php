<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package App\Model
 */
class Group extends Model
{
    protected $guarded = [];

    /**
     * @return Collection
     */
    public static function getAll() : Collection
    {
        return self::get();
    }
}
