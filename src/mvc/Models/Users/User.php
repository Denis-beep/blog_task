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

    /** @var string
     *  Переменная для позднего статического связывания таблиц.
     */
    protected static string $tableName = 'users';

    public array $fillable = [
        'nickname',
        'email',
        'isConfirmed',
        'role',
        'isBanned',
        'createdAt',
    ];

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
