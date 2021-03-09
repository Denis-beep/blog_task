<?php


namespace mvc\Models\Articles;

use mvc\Models\Model;
use traits\hasGetters;

class Article extends Model
{
    use hasGetters;

    protected static string $tableName = 'articles';

    /** @var string */
    protected string $name;

    /** @var string */
    protected string $text;

    /** @var int */
    protected int $authorId;

    /** @var string */
    protected string $createdAt;
}