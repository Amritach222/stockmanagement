<?php

namespace Samundra\File;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class SamundraFileHelper
 * @package Samundra\File
 */
class SamundraFileHelper
{
    /**
     * @param $file
     * @param string $location
     * @param array|null $allowedExtension
     * @param string $fileDriver
     * @return array
     * It saves file provided the File as raw input from the post method
     * location refers to file path like uploaded or profile or order
     * allowedExtension is set of array containing the allowed extensions as ['jpg','png']
     */
    public function saveFile($file, string $location, array $allowedExtension = null,  $fileDriver = 'local')
    {
        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
        $now = Carbon::now();
        $year = $now->year;
        $month = $months[$now->month - 1];
        $defaultLocation = $location . '/' . $year . '/' . $month;
        Storage::makeDirectory($defaultLocation);
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getClientMimeType();
        if ($allowedExtension === null) {
            $filename = uniqid() . '.' . $extension;
            try {
                Storage::disk($fileDriver)->putFileAs($defaultLocation, $file, $filename);
//                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
//                    $this->makeThumbnailFromSavedFile($defaultLocation, $filename);
//                }
            } catch (Exception $e) {
                return ['success' => false, 'message' => "Error while saving file", 'data' => []];
            }
        } else {
            if (!in_array($extension, $allowedExtension)) {
                return ['success' => false, 'message' => "File extension doesnot match the rule", 'data' => []];
            }
            $filename = uniqid() . '.' . $extension;
            try {
                Storage::disk($fileDriver)->putFileAs($defaultLocation, $file, $filename);
//                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
//                    $this->makeThumbnailFromSavedFile($defaultLocation, $filename);
//                }
            } catch (Exception $e) {
                return ['success' => false, 'message' => "Error while saving file", 'data' => []];
            }
        }
        $result = $defaultLocation.'/'.$filename;
        $original_filename = $file->getClientOriginalName();
        $arr = ['extension'=> $extension,'mime_type'=> $mimeType,'filename'=>$filename,'original_filename'=>$original_filename,'link'=>$result];
        return ['success' => true, 'message' => "file saved successfully", 'data' => $arr];
    }


    /**
     * @param $files
     * @param string $location
     * @param array|null $allowedExtension
     * @param string $fileDriver
     * @return array
     * It saves file provided the Files as raw input from the post method and in array
     * location refers to file path like uploaded or profile or order
     * allowedExtension is set of array containing the allowed extensions as ['jpg','png']
     */
    public function saveMultipleFiles($files, $location, array $allowedExtension = null, $fileDriver = 'local')
    {
        $fileArr = [];
        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
        $now = Carbon::now();
        $year = $now->year;
        $month = $months[$now->month - 1];
        $defaultLocation = $location . '/' . $year . '/' . $month;
        Storage::makeDirectory($defaultLocation);
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $org_name = $file->getClientOriginalName();
            $org_mime = $file->getMimeType();
            $size = $file->getSize();
            if ($allowedExtension === null) {
                $filename = uniqid() . '.' . $extension;
                try {
                    Storage::disk($fileDriver)->putFileAs($defaultLocation, $file, $filename);
//                    if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
//                        $this->makeThumbnailFromSavedFile($defaultLocation, $filename);
//                    }
                    $fileData = [
                        'file_name'=>$filename,
                        'file_extension'=>$extension,
                        'file_original_name'=>$org_name,
                        'file_original_mime'=>$org_mime,
                        'file_size'=>$size,
                        'file_storage_location'=>$defaultLocation,
                    ];
                    array_push($fileArr, $fileData);
                } catch (Exception $e) {
                    return ['success' => false, 'message' => "Error while saving file", 'data' => []];
                }
            } else {
                if (!in_array($extension, $allowedExtension)) {
                    return ['success' => false, 'message' => "File extension doesnot match the rule", 'data' => []];
                }
                $filename = uniqid() . '.' . $extension;
                try {
                    Storage::disk($fileDriver)->putFileAs($defaultLocation, $file, $filename);
//                    if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
//                        $this->makeThumbnailFromSavedFile($defaultLocation, $filename);
//                    }
                    $fileData = [
                        'file_name'=>$filename,
                        'file_extension'=>$extension,
                        'file_original_name'=>$org_name,
                        'file_original_mime'=>$org_mime,
                        'file_size'=>$size,
                        'file_storage_location'=>$defaultLocation,
                    ];
                    array_push($fileArr, $fileData);
                } catch (Exception $e) {
                    return ['success' => false, 'message' => "Error while saving file", 'data' => []];
                }
            }
        }
        return ['success' => true, 'message' => "file saved successfully", 'data' => $fileArr];
    }

    public function getMultipleFileSize($files)
    {
        $total = 0;
        foreach ($files as $file) {
            $size = $file->getSize();
            $total = $total+$size;
        }
        return $total;
    }

    /**
     * @param string $location
     * @param string $imageName
     * @param string $fileDriver
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * this method creates thumbnail provided the location and image name
     * location refers to full path of an image as, c:/example/example/
     * imageName should have extension on it if required as, sample.jpg
     */
    public function makeThumbnailFromSavedFile( $location,  $imageName,  $fileDriver = 'local')
    {
        $path = $location . '/' . $imageName;
        $image = Image::make(Storage::disk($fileDriver)->get($path));
        $tempPreviewPath = 'app/'.$location . '/' . 't_' . $imageName;
        $image->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($tempPreviewPath));
//        Storage::disk($fileDriver)->put($tempPreviewPath, $image);
    }

    /**
     * @param $file
     * @param string $location
     * @param string $fileDriver
     * @return array
     * this method creates thumbnails from the raw file uploaded
     * file is the raw input from post method
     * location refers to file path like uploaded or profile or order
     */
    public function makeThumbnailFromRawFile($file,  $location,  $fileDriver = 'local')
    {
        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
        $now = Carbon::now();
        $year = $now->year;
        $month = $months[$now->month - 1];
        $defaultLocation = 'app/'.$location . '/' . $year . '/' . $month;
        Storage::makeDirectory($defaultLocation);
        $extension = $file->getClientOriginalExtension();
        $imageName = 't_' . uniqid() . '.' . $extension;
        $tempPreviewPath = $defaultLocation.'/'.$imageName;
        $image = Image::make($file);
        $image->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($tempPreviewPath));
//        Storage::disk($fileDriver)->putFileAs($defaultLocation, $image, $imageName);
        return ['success' => true, 'message' => "file saved successfully", 'data' => $imageName];
    }

    /**
     * @param string $date
     * @param string $filename
     * @param string $location
     * @return array
     * this method creates the file path for retrieve from given
     * date is in timestamp format
     * file name contains the extension also
     * location refers to file path like uploaded or profile or order
     */
    public function filePathCreater( $date,  $filename,  $location)
    {
        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
        $date = Carbon::createFromTimeString($date);
        $year = $date->year;
        $month = $months[$date->month - 1];
        $path = $location . '/' . $year . '/' . $month . '/' . $filename;
        if (Storage::exists($path)) {
            return ['success' => true, 'message' => "file path created", 'data' => $path];
        } else {
            return ['success' => false, 'message' => "file not found", 'data' => []];
        }
    }

    /**
     * @param string $filePath
     * @param string $fileDriver
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * this method retrieve the file from the saved storage if provided the file path with file name
     * it is generally used with the filePathCreater function
     */
    public function retrieveFile( $filePath,  $fileDriver = 'local')
    {
        $extension = Storage::disk($fileDriver)->mimetype($filePath);
        $contents = Storage::get($filePath);
        if ($extension == 'image/jpg' || $extension == 'image/jpeg' || $extension == 'image/png') {
            return response($contents, 200)->header('Content-Type', $extension);
        }
        return response($contents, 200)->header('Content-Type', $extension);
    }

    public function deleteFile($filelink, $fileDriver = 'local'){
        $delete = Storage::disk($fileDriver)->delete($filelink);
        return $delete;
    }


}
