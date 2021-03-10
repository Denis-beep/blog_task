<?php


namespace mvc\Models\Articles;

use mvc\Models\Model;
use traits\hasGetters;

/**
 * Class Article
 * @package mvc\Models\Articles
 */
class Article extends Model
{
    use hasGetters;

    /** An array for listing the properties available to getters.
     * @var array|string[]
     */
    public array $fillable = [
        'name',
        'text',
        'authorId',
        'createdAt',
        'status'
    ];

    /**
     * Late static linking.
     * Pass the table name through static inheritance.
     * @var string
     */
    protected static string $tableName = 'articles';

    /**
     * @var string
     */
    protected string $name;

    /** @var string */
    protected string $text;

    /** @var int */
    protected int $authorId;

    /** @var string */
    protected string $createdAt;

    /** @var string */
    protected string $status;
}