<?php

namespace mvc\Models\Users;

use mvc\Controllers\CoreController;
use mvc\Models\Model;
use traits\hasGetters;

/**
 * Class User
 * @package mvc\Models\Users
 */
class User extends Model
{
    use hasGetters;

    protected static string $tableName = 'users';

    /**
     * @var string
     */
    protected string $nickname;
    /**
     * @var string
     */
    protected string $email;
    /**
     * @var string
     */
    protected string $isConfirmed;
    /**
     * @var string
     */
    protected string $role;
    /**
     * @var string
     */
    protected string $isBanned;
    /**
     * @var string
     */
    protected string $createdAt;
}
