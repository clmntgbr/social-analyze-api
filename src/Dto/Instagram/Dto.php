<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InstagramImageVersionsDto
{
    public function __construct(
        #[SerializedName("additional_items")]
        public InstagramAdditionalItemsDto $additionalItems,

        #[SerializedName("items")]
                                           /** @var InstagramImageItemDto[] */
        public array $items,

        #[SerializedName("scrubber_spritesheet_info_candidates")]
        public InstagramSpritesheetInfoDto $spritesheetInfoCandidates
    ) {}
}

class InstagramAdditionalItemsDto
{
    public function __construct(
        #[SerializedName("first_frame")]
        public InstagramImageItemDto $firstFrame,

        #[SerializedName("igtv_first_frame")]
        public InstagramImageItemDto $igtvFirstFrame,

        #[SerializedName("smart_frame")]
        public InstagramImageItemDto $smartFrame
    ) {}
}

class InstagramImageItemDto
{
    public function __construct(
        #[SerializedName("height")]
        public int $height,

        #[SerializedName("url")]
        public string $url,

        #[SerializedName("url_original")]
        public string $urlOriginal,

        #[SerializedName("width")]
        public int $width
    ) {}
}

class InstagramSpritesheetInfoDto
{
    public function __construct(
        #[SerializedName("default")]
        public ?InstagramSpritesheetDetailsDto $default = null
    ) {}
}

class InstagramSpritesheetDetailsDto
{
    public function __construct(
        #[SerializedName("file_size_kb")]
        public int $fileSizeKb,

        #[SerializedName("max_thumbnails_per_sprite")]
        public int $maxThumbnailsPerSprite,

        #[SerializedName("rendered_width")]
        public int $renderedWidth,

        #[SerializedName("sprite_height")]
        public int $spriteHeight,

        #[SerializedName("sprite_urls")]
                   /** @var string[] */
        public array $spriteUrls,

        #[SerializedName("sprite_width")]
        public int $spriteWidth,

        #[SerializedName("thumbnail_duration")]
        public float $thumbnailDuration,

        #[SerializedName("thumbnail_height")]
        public int $thumbnailHeight,

        #[SerializedName("thumbnail_width")]
        public int $thumbnailWidth,

        #[SerializedName("thumbnails_per_row")]
        public int $thumbnailsPerRow,

        #[SerializedName("total_thumbnail_num_per_sprite")]
        public int $totalThumbnailNumPerSprite,

        #[SerializedName("video_length")]
        public float $videoLength
    ) {}
}
