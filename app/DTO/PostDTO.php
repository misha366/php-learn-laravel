<?php

namespace App\DTO;

// ДТО файнал и без сеттеров - это иммутабельный класс
final class PostDTO
{
    private string $title;
    private string $content;
    // ?type указывает на то что тут может лежать как и указанный тип так и null явно
    private ?string $image;
    private ?int $category_id;
    private ?array $tag_ids;

    public function __construct(string $title,
                                string $content,
                                ?string $image,
                                ?int $category_id,
                                ?array $tags)
    {
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->category_id = $category_id;
        $this->tag_ids = $tags;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["title"] ?? throw new \InvalidArgumentException("Title is required."),
            $data["content"] ?? throw new \InvalidArgumentException("Content is required."),
            $data["image"] ?? null,
            $data["category_id"] ?? null,
            $data["tag_ids"] ?? null
        );
    }

    public static function toArray(PostDTO $post): array
    {
        return [
            "title" => $post->title,
            "content" => $post->content,
            "image" => $post->image,
            "category_id" => $post->category_id,
            "tag_ids" => $post->tag_ids
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getTagIds(): ?array
    {
        return $this->tag_ids;
    }
}
