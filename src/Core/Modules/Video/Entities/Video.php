<?php

namespace Costa\Core\Modules\Video\Entities;

use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Modules\Video\ValueObject\Image;
use Costa\Core\Modules\Video\ValueObject\Media;
use Costa\Core\Utils\Traits\MagicMethodsTrait;
use Costa\Core\Utils\Validations\DomainValidation;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;

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
        private ?DateTime $createdAt = null,
        private ?Image $thumbFile = null,
        private ?Image $thumbHalf = null,
        private ?Image $bannerFile = null,
        private ?Media $trailerFile = null,
        private ?Media $videoFile = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?: new DateTime();

        $this->validated();
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

    protected function validated()
    {
        DomainValidation::strMaxLength($this->title);
        DomainValidation::strMinLength($this->title);

        DomainValidation::strCanNullAndMinLength($this->description);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}
