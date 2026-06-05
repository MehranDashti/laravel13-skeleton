<?php

namespace App\Http\Resources\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * trait S3Resource
 *
 * @package App\Http\Resources\Traits
 */
trait S3Resource
{
    /**
     * @param array|string $field
     *
     * @return string|null
     */
    protected function getUrl(array|string $field): ?string
    {
        if ($this->$field && app()->environment() !== 'testing') {
            return Storage::disk('s3-read')->url(
                $this->$field,
                now()->addHour(),
                ['ResponseContentDisposition' => 'attachment']
            );
        }

        return null;
    }

    /**
     * @param string $field
     *
     * @return array
     */
    protected function getUrls(string $field): array
    {
        $files = [];
        if ($this->$field && app()->environment() !== 'testing') {
            foreach ($this->$field as $item) {
                $file = Storage::disk('s3-read')->url(
                    $item,
                    now()->addHour(),
                    ['ResponseContentDisposition' => 'attachment']
                );
                $files = array_merge($files, [$file]);
            }
        }

        return $files;
    }

    /**
     * @param string $field
     *
     * @return string|null
     */
    protected function getArrayUrl(string $field): ?string
    {
        if ($field && app()->environment() !== 'testing') {
            return Storage::disk('s3-read')->url(
                $field,
                now()->addHour(),
                ['ResponseContentDisposition' => 'attachment']
            );
        }

        return null;
    }
}
