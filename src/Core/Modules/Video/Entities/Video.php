<?php

namespace Costa\Core\Modules\Video\Entities;

use Costa\Core\Modules\Video\Enums\Rating;
use Costa\Core\Modules\Video\ValueObject\Image;
use Costa\Core\Modules\Video\ValueObject\Media;
use Costa\Core\Utils\Abstracts\EntityAbstract;
use Costa\Core\Utils\Exceptions\DomainNotificationException;
use Costa\Core\Utils\Notifications\DomainNotification;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;
use Exception;

class Video extends EntityAbstract
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

    protected function validated()
    {
        if (empty($this->title)) {
            $this->domainNotification->addError([
                'context' => 'video',
                'message' => 'should not be empty or null'
            ]);
        }

        if (strlen($this->title) < 3) {
            $this->domainNotification->addError([
                'context' => 'video',
                'message' => 'invalid quantity'
            ]);
        }

        if ($this->description && strlen($this->description) < 3) {
            $this->domainNotification->addError([
                'context' => 'description',
                'message' => 'invalid quantity'
            ]);
        }

        if ($this->domainNotification->hasError()) {
            throw new DomainNotificationException($this->domainNotification);
        }
    }
}
