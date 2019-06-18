<?php namespace GeneaLabs\NovaFileUploadField;

use CFPropertyList\CFPropertyList;
use Illuminate\Http\UploadedFile;
use Laravel\Nova\Fields\Deletable;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;
use ReflectionProperty;

class FileUpload extends File
{
    use Deletable;

    public $component = 'nova-file-upload-field';


    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $request = $this->convertWebloc($request, $requestAttribute);

        if (is_string($request->$requestAttribute)) {
            $uploadedFile = $this->createUploadedFileFromUrl($request->$requestAttribute);
            $request = $this->updateRequestWithUploadedFile($request, $uploadedFile, $requestAttribute);
            $this->updateRequestWithUploadedFile(request(), $uploadedFile, $requestAttribute);
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

    protected function convertWebloc(NovaRequest $request, string $requestAttribute)
    {
        if ($request->hasFile($requestAttribute)
            && $request->file($requestAttribute)->getClientOriginalExtension() === "webloc"
        ) {
            $content = $request->file($requestAttribute)->get();
            $parser = new CFPropertyList;
            $parser->parseBinary($content);
            $plist = $parser->toArray();
            $request->$requestAttribute = $plist["URL"];
        }

        return $request;
    }

    protected function createUploadedFileFromUrl(string $url) : UploadedFile
    {
        $tempPath = sys_get_temp_dir() . "/" . str_random();
        touch($tempPath);
        file_put_contents($tempPath, file_get_contents($url));

        return new UploadedFile($tempPath, $url);
    }

    protected function updateRequestWithUploadedFile(
        $request,
        UploadedFile $uploadFile,
        string $requestAttribute
    ) {
            $request->merge([$requestAttribute => $uploadFile]);
            $fileBag = $request->files;
            $fileBag->set($requestAttribute, $uploadFile);
            $request->files = $fileBag;
            $request->$requestAttribute = $uploadFile;
            $refProperty   = new ReflectionProperty(get_class($request), "convertedFiles");
            $refProperty->setAccessible(true);
            $refProperty->setValue($request, null);
            app()->instance(get_class($request), $request);

            return $request;
    }
}
