<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    public function uploadFile($request, $data, $name, $inputName = 'files')
    {
        $requestFile = $request->file($inputName);
        try {
            $dir = 'public/files/' . $name;
            $fixName = $data->id . '-' . $name . '.' . $requestFile->extension();

            if ($requestFile) {
                Storage::putFileAs($dir, $requestFile, $fixName);
                $request->file = 'files/' . $name . '/' . $fixName;

                $data->update([
                    $inputName => $request->file,
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    // delete file
    public function deleteFile($fileName = 'files')
    {
        try {
            if ($fileName) {
                Storage::delete('public/files/' . $fileName);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    /**
     * For Upload Images.
     * @param mixed $request
     * @param mixed $data
     * @param mixed $name
     * @param mixed|null $inputName
     * @return bool|string
     */
    public function uploadImage($request, $data, $name, $inputName = 'image')
    {
        $requestFile = $request->file($inputName);
        try {
            $dir = 'public/images/' . $name;
            $fixName = $data->id . '-' . $name . '.' . $requestFile->extension();

            if ($requestFile) {
                Storage::putFileAs($dir, $requestFile, $fixName);
                $request->image = $fixName;

                $data->update([
                    $inputName => $request->image,
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    // public function uploadPhoto($request, $data, $name)
    // {
    //     try {
    //         $dir = 'public/photos/' . $name;
    //         $fixName = $data->id . '-' . $name . '.' . $request->file('photo')->extension();

    //         if ($request->file('photo')) {
    //             Storage::putFileAs($dir, $request->file('photo'), $fixName);
    //             $request->photo = $fixName;

    //             $data->update([
    //                 'photo' => $request->photo,
    //             ]);
    //         }
    //     } catch (\Throwable $th) {
    //         report($th);

    //         return $th->getMessage();
    //     }
    // }

    /**
     * Delete an image file.
     *
     * @param string $fileName
     * @param string $directory
     * @return bool|string
     */
    public function deleteImage($fileName, $directory = 'public/images')
    {
        try {
            if ($fileName) {
                Storage::delete($directory . '/' . $fileName);
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            report($th);
            return $th->getMessage();
        }
    }
}