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
            $dir = 'public/images/' . $name . '/image/';
            $fixName = $data->id . '-' . $name . '-' . uniqid() . '.' . $requestFile->extension();

            if ($requestFile) {
                Storage::putFileAs($dir, $requestFile, $fixName);
                $request->image = '/storage/images/' . $name . '/' . $fixName;

                $data->update([
                    $inputName => ["url" => $request->image],
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    public function uploadMultipleImages($request, $data, $name, $inputName = 'images')
    {
        try {
            $dir = 'public/images/' . $name . '/images/';
            $uploadedFiles = [];
            $counter = 1;
            if ($request->hasFile($inputName)) {
                foreach ($request->file($inputName) as $file) {
                    $fixName = $data->id . '-' . $name . '-' . uniqid() . '-' . $counter . '.' . $file->extension();
                    Storage::putFileAs($dir, $file, $fixName);
                    $uploadedFiles[] = '/storage/images/' . $name . '/' . $fixName;
                    $counter++;

                    // foreach ($request->file('images') as $imagefile) {
                    //     $image = new CourseImages;
                    //     $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
                    //     $image->url = $path;
                    //     $image->course_id = $course->id;
                    //     $image->save();
                    // }
                }

                $data->update([
                    $inputName => $uploadedFiles,
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