<?php


namespace mvc\Models\Articles;

use mvc\Models\Model;
use mvc\Models\Users\User;

class Article extends Model
{
    public static string $tableName = 'articles';
    private string $title;
    private string $text;
    private User $author;

    public function __construct(string $title, string $text, User $author)
    {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
    }

    public function getTitle() :string
    {
        return $this->title;
    }

    public function getText() :string
    {
        return $this->text;
    }

    public function getAuthor() :User
    {

    }
}