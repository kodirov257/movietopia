<?php

namespace App\Entity;

class Meta
{
    public string $title;
    public string $keywords;
    public string $description;

    public function __construct($title, $keywords, $description)
    {
        $this->title = $title;
        $this->keywords = $keywords;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'keywords' => $this->keywords,
            'description' => $this->description,
        ];
    }
}
