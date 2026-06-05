<?php

namespace App\Services\Traits;

use Exception;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\DTO\Contracts\FromArrayDTOInterface;
use App\DTO\Contracts\FromRequestDTOInterface;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Trait FileServiceTrait
 *
 * @package App\Services\Contracts
 */
trait FileServiceTrait
{
    /**
     * @param array $data
     * @param Model $model
     * @param FromRequestDTOInterface|FromArrayDTOInterface $dto
     * @param string $field
     * @param string $directory
     *
     * @throws Exception
     */
    private function updateS3File(array &$data, Model $model, FromRequestDTOInterface|FromArrayDTOInterface $dto, string $field, string $directory): void
    {
        if ($dto->$field && app()->environment() !== 'testing') {
            Storage::disk('s3-write')->delete($model->$field);
            $data[$field] = $this->uploadImageToS3($dto->$field, $directory);
        }
    }

    /**
     * @param string $filePath
     */
    private function deleteFile(string $filePath): void
    {
        if (! Str::contains($filePath, storage_path())) {
            Storage::delete($filePath);
        } else {
            unlink($filePath);
        }
    }

    /**
     * @param WithMultipleSheets $class
     * @param string $filePath
     *
     * @return array<string>
     */
    private function generateReportExcel(WithMultipleSheets $class, string $filePath): array
    {
        $fileName = time() . '-' . rand(0, 9999999) . '.xlsx';
        $filePath .= $fileName;
        Excel::store($class, $filePath);

        return [
            'fileName' => $fileName,
            'filePath' => $filePath,
        ];
    }

    /**
     * @param string $fileName
     * @param string $filePath
     * @param string $fileCloudPath
     *
     * @return string
     */
    private function uploadFileToCloud(string $fileName, string $filePath, string $fileCloudPath): string
    {
        $fileContent = file_get_contents(storage_path('app') . $filePath);
        $fileCloudPath .= $fileName;
        Storage::disk('s3-write')->put($fileCloudPath, $fileContent);

        return $fileCloudPath;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function prepareBaseExportPayload(array $data): array
    {
        return [
            'service' => config('settings.export_hephaestus_service'),
            'data' => $data,
            'mime_type' => config('settings.export_hephaestus_mime_type'),
        ];
    }

    /**
     * @param string $imageCode
     * @param string $s3Directory
     *
     * @return string
     *
     * @throws Exception
     */
    private function uploadImageToS3(string $imageCode, string $s3Directory): string
    {
        if (app()->environment() === 'testing') {
            return 'Registered';
        }
        $imageInfo = $this->uploadBase64File($imageCode);
        $fileCloudPath = $this->uploadFileToCloud($imageInfo['fileName'], $imageInfo['filePath'], $s3Directory);
        $this->deleteFile($imageInfo['filePath']);

        return $fileCloudPath;
    }

    /**
     * @param string|null $imageCode
     *
     * @return array<string>|null
     *
     * @throws Exception
     */
    private function uploadBase64File(?string $fileCode): ?array
    {
        if (! $fileCode) {
            return null;
        }
        $explodedCode = explode(',', $fileCode);
        $decodeFile = base64_decode($explodedCode[1]);
        $fileExtension = $this->checkExistsBase64MimeType($explodedCode[0]);
        $fileName = random_int(100, 100000) . '-' . time() . '.' . $fileExtension;
        $filePath = "/public/application/{$fileName}";
        Storage::put($filePath, $decodeFile);

        return [
            'fileName' => $fileName,
            'filePath' => $filePath,
        ];
    }

    /**
     * @param string $uploadMimetype
     *
     * @return string
     */
    private function checkExistsBase64MimeType(string $uploadMimetype): string
    {
        foreach ($this->getMimeType() as $key => $mimeType) {
            if (str_contains($uploadMimetype, $key)) {
                return $mimeType;
            }
        }

        return 'txt';
    }

    /**
     * @return array<string>
     */
    private function getMimeType(): array
    {
        return [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/pdf' => 'pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'doc',
            'application/msword' => 'docx',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/vnd.ms-powerpoint' => 'pptx',
            'vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-excel' => 'xlsx',
            'mp4' => 'mp4',
            'csv' => 'csv',
            'doc' => 'doc',
            'docx' => 'docx',
            'xlsx' => 'xlsx',
            'xls' => 'xls',
            'pptx' => 'pptx',
            'ppt' => 'ppt',
            'html' => 'html',
            'pdf' => 'pdf',
            'png' => 'png',
            'svg' => 'svg',
            'jpg' => 'jpg',
            'jpeg' => 'jpeg',
            'gif' => 'gif',
            'webp' => 'webp',
        ];
    }
}
