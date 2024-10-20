<?php

declare(strict_types=1);

namespace App\Configs;

use App\Exceptions\ViewNotFoundException;

class View
{
    protected string $view;
    protected string $title;
    protected array $params;
    public function __construct(
        $view,
        $params = [],
        $title
    ) {
        $this->view = $view;
        $this->params = $params;
        $this->title = $title;
    }

    public static function make(string $view, array $params = [], string $title = ''): self
    {
        return new static($view, $params, $title);
    }

    public function render(): string
    {
        $viewPath = VIEWS_PATH . '/' . $this->view . '.php';
        $layoutPath = VIEWS_PATH . '/layouts/main.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException;
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include $viewPath;
        $title = $this->title;
        $content =  ob_get_clean();
        include $layoutPath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
