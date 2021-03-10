<?php


namespace mvc\View;


class View
{
    private string $templatesPath;

    public function __construct(string $templatesPath = __DIR__ . '/../../templates')
    {
        $this->templatesPath = $templatesPath;
    }

    public function template(string $templateName, array $vars = [], int $code = 200)
    {
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();

        http_response_code($code);

        echo $buffer;
    }
}