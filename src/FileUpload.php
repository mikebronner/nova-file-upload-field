<?php namespace GeneaLabs\NovaFileUploadField;

use Laravel\Nova\Fields\Deletable;
use Laravel\Nova\Fields\File;
use Illuminate\Http\UploadedFile;
use ReflectionProperty;
use Laravel\Nova\Http\Requests\NovaRequest;

class FileUpload extends File
{
    use Deletable;

    public $component = 'nova-file-upload-field';


    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->filled($attribute)) {
            $tempFile = tmpfile();
            $tempPath = stream_get_meta_data($tempFile)['uri'];
            file_put_contents($tempPath, file_get_contents($request->input($attribute)));
            $uploadFile = new UploadedFile($tempPath, $request->input($attribute));

            $request->merge([$attribute => $uploadFile]);
            $fileBag = $request->files;
            $fileBag->set($attribute, $uploadFile);
            $request->files = $fileBag;
            $refProperty   = new ReflectionProperty(get_class($request), "convertedFiles");
            $refProperty->setAccessible(true);
            $refProperty->setValue($request, null);
            app()->instance(get_class($request), $request);
        }

        if (is_null($file = $request->file($requestAttribute))) {
            return;
        }

        $result = call_user_func($this->storageCallback, $request, $model);

        if ($result === true) {
            return;
        }

        if (! is_array($result)) {
            return $model->{$attribute} = $result;
        }

        foreach ($result as $key => $value) {
            $model->{$key} = $value;
        }

        if ($this->isPrunable()) {
            return function () use ($model, $request) {
                call_user_func(
                    $this->deleteCallback,
                    $request,
                    $model,
                    $this->getStorageDisk(),
                    $this->getStoragePath()
                );
            };
        }
    }
}
