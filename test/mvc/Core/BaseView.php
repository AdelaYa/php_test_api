<?php

namespace Core;

class BaseView
{
    private string $layout;

    private array $data;
    public function __construct($layout, array $data = []) {
        $this->layout = $layout;
        $this->data   = $data;
    }

    public function render(): void {
        // Base layout
        include 'mvc/Views/template.php';
    }

    public function renderContent(): void {
        extract($this->data);
        include "mvc/Views/$this->layout.php";
    }
}