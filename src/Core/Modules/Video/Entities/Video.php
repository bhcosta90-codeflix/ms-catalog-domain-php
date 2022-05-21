<?php

namespace Costa\Core\Modules\Video\Entities;

use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Modules\Video\ValueObject\Image;
use Costa\Core\Modules\Video\ValueObject\Media;
use Costa\Core\Utils\Abstracts\EntityAbstract;
use Costa\Core\Utils\Contracts\EntityInterface;
use Costa\Core\Utils\Exceptions\DomainNotificationException;
use Costa\Core\Utils\Factories\VideoValidatorFactory;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;
use Exception;

class Video extends EntityAbstract implements EntityInterface
{
    protected array $categories = [];
    protected array $genres = [];
    protected array $castMembers = [];

    public function __construct(
        protected string $title,
        protected string $description,
        protected int $yearLaunched,
        protected int $duration,
        protected bool $opened,
        protected Rating $rating,
        protected bool $published = false,
        protected ?Uuid $id = null,
        protected ?DateTime $createdAt = null,
        protected ?Image $thumbFile = null,
        protected ?Image $thumbHalf = null,
        protected ?Image $bannerFile = null,
        protected ?Media $trailerFile = null,
        protected ?Media $videoFile = null,
    ) {
        parent::__construct();

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

    public function thumbFile(): ?Media
    {
        return $this->thumbFile;
    }

    public function thumbHalf(): ?Media
    {
        return $this->thumbHalf;
    }

    public function bannerFile(): ?Media
    {
        return $this->bannerFile;
    }

    public function trailerFile(): ?Media
    {
        return $this->trailerFile;
    }

    public function videoFile(): ?Media
    {
        return $this->videoFile;
    }

    protected function validated()
    {
        VideoValidatorFactory::create()->validate($this);

        if ($this->notifications->hasError()) {
            throw new DomainNotificationException($this->notifications);
        }
    }
}
