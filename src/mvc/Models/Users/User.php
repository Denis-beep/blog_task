<?php

namespace MVC\Models\Users;

class User
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
 * @return string
 */
    public function getName(): string
    {
        return $this->name;
    }
}
