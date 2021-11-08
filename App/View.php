<?php

namespace App;

class View
{
    public function __construct(private string $view, private array $params)
    {
    }

    public function __toString()
    {
        return $this->render();
    }

    public static function make(string $view, array $params = [])
    {
        return new static($view, $params);
    }

    public function render(): string
    {
        $view = $this->getViewPath();

        if (!file_exists($view)) {
            throw new \Exception("View {$this->view} does not exists");
        }

        return $this->getViewContent($view);
    }

    protected function getViewPath()
    {
        return realpath(VIEW_PATH) . '/' . str_replace('.', '/', $this->view) . '.php';
    }

    protected function getViewContent(string $path)
    {
        ob_start();
        include $path;

        return ob_get_clean();
    }
}
