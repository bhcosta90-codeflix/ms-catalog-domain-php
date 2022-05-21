<?php

namespace Costa\Core\Modules\Video\Events;

use Costa\Core\Modules\Video\Entities\Video;
use Costa\Core\Utils\Contracts\EventInterface;

class VideoCreatedEvent implements EventInterface
{
    public function __construct(protected Video $video)
    {
        //
    }

    public function getEventName(): string
    {
        return 'video.created';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->video->id(),
            'video_path' => $this->video->videoFile()?->path,
            'trailer_path' => $this->video->trailerFile()?->path,
        ];
    }
}
