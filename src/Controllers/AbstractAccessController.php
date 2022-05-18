<?php
namespace App\Controllers;

use App\Model\User;
use App\Exception\AccessDeniedException;

/**
 * Class AbstractAccessController
 * @package App\Controllers
 */
abstract class AbstractAccessController
{
    protected $user;

    /**
     * AbstractAccessController constructor.
     */
    public function __construct()
    {
        $this->user = User::getBySession() ?: NULL;
    }

    /**
     * @param int $access_level
     * @return bool
     * @throws AccessDeniedException
     */
    protected function checkAccess(int $access_level)
    {
        if ($this->user->group_id < $access_level) {
            throw new AccessDeniedException();
        }
        return true;
    }

    /**
     * @param string $location
     */
    protected function redirect(string $location = '/') {
        header('Location: ' . $location);
        die();
    }
}
