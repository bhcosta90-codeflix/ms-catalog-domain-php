<?php

namespace Costa\Core\Modules\Video\Entities;

use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Utils\Traits\MagicMethodsTrait;
use Costa\Core\Utils\ValueObject\Uuid;

class Video
{
    use MagicMethodsTrait;

    protected array $categories = [];
    protected array $genres = [];
    protected array $castMembers = [];

    public function __construct(
        private string $title,
        private string $description,
        private int $yearLaunched,
        private int $duration,
        private bool $opened,
        private Rating $rating,
        private bool $published = false,
        private ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
    }

    public function addCategory($id)
    {
        array_push($this->categories, $id);
    }

    public function removeCategory(string $id)
    {
        unset($this->categories[array_search($id, $this->categories)]);
    }

    public function addGenre($id)
    {
        array_push($this->genres, $id);
    }

    public function removeGenre(string $id)
    {
        unset($this->genres[array_search($id, $this->genres)]);
    }

    public function addCastMember($id)
    {
        array_push($this->castMembers, $id);
    }

    public function removeCastMember(string $id)
    {
        unset($this->castMembers[array_search($id, $this->castMembers)]);
    }
}
