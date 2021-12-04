<?php

namespace App\Traits;

use Image;
use Intervention\Image\Exception\ImageException;

trait ControlBlocks
{
    public function _files_upload_control_block($files, $model, $class_name)
    {
        $file_data = [];
        foreach ($files as $name => $file) {
            if ($model) {
                $this->_getFiles($model, $name, $class_name, true); //  remove old images
            }
            if(is_array($file)) {
                foreach($file as $nestedName => $nestedFile){
                    $image = $this->__file_upload($name, $nestedFile, $class_name);
                    if(!$image) {
                        $file_data[$name][] = $this->__file_upload($name, $nestedFile, $class_name, true);
                    }else {
                        $file_data[$name][] = $image;
                    }
                }
            }else{
                $file_data[$name] = $this->__file_upload($name, $file, $class_name);
            }
        }
        return $file_data;
    }


    public function __file_upload($name, $file, $class_name, $is_not_image = false)
    {
        $settings = $class_name::IMAGE_SETTINGS[$name];
        $fileName = time().rand(10,10000);
        $destinationPath = storage_path($settings['path']);
        if(!$is_not_image) {
            try {
                $img = Image::make($file->path());
                if(!empty($settings['sizes'])) {
                    foreach ($settings['sizes'] as $key => $size) {
                        if (!is_array($size)) {
                            $width = $size;
                            $height = $size;
                        } else {
                            $width = $size[0];
                            $height = $size[1];
                        }
                        $img->resize($width, $height)->save($destinationPath . '/' . $fileName . '_' . $key . '.' . $file->extension());
                    }
                }else {
                    $img->save($destinationPath . '/' . $fileName . '.' . $file->extension());
                }
                $extension  = $file->extension();
            } catch (ImageException $e) {
                return false;
            }
        }else{
            $fileName .= ".". $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $extension  = $file->getClientOriginalExtension();
        }
        return [
            'name' => $fileName,
            'extension' => $extension
        ];
    }



    public function _getFiles($model, $column, $class_name = null , $remove = null, $alt_column = null)
    {
        if(!$class_name) {
            $class_name = get_class($model);
        }
        $files = [];
        if (!empty($model->$column)) {
            $settingItem = isset($class_name::IMAGE_SETTINGS[$column]) ? $class_name::IMAGE_SETTINGS[$column] : $class_name::IMAGE_SETTINGS[$alt_column];
            $extension = $column . '_extension';
            if(!empty($settingItem['sizes'])) {
                foreach ($settingItem['sizes'] as $key => $size) {
                    $name = asset('/'. $class_name::IMAGE_SETTINGS[$column]['read_path'] . $model->$column . '_' . $key . '.' . $model->$extension);
                    $files[$key] = $name;
                    if ($remove) {
                        $this->__removeFiles($name);
                    }
                }
            }else{
                $name = asset( '/'.$settingItem['read_path'] . $model->$column . '.' . $model->$extension);
                $files['full'] = $name;
                if ($remove) {
                    $this->__removeFiles($name);
                }
            }
        }
        return $files;
    }

    public function __removeFiles($filename)
    {
        if (file_exists(storage_path($filename))) {
            unlink(storage_path($filename));
        }
    }
}
