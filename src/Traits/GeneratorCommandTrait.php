<?php

namespace Teksite\Lareon\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait GeneratorCommandTrait
{
    /**
     * @param string $stub
     * @param array $replace
     * @param string $destination
     * @return void
     */
    public function replaceStub(string $stub, array $replace, string $destination): void
    {
        $stubPath = $this->getStubFile($stub);
        $replacedContent = $this->getStubContent($stubPath, $replace);
        if (!File::exists(dirname($destination))) {
            File::makeDirectory(dirname($destination), 0755, true);
        }

        // Write to the file
        try {
            File::put($destination, $replacedContent);
        } catch (\Exception $e) {
            dd("Error writing to file: " . $e->getMessage());
        }

    }

    /**
     * @param $path
     * @return string
     */
    protected function getStubFile($path): string
    {
        return app('cms.stubs') . trim($path, '\/');
    }

    /**
     * @param string $stubPath
     * @param array $replacements
     * @return string
     */
    private function getStubContent(string $stubPath, array $replacements = []): string
    {
        if (!File::exists($stubPath)) {
            $this->error('there is not ant stub at ' . $stubPath);
            return '';
        }

        $content = File::get($stubPath);

        if (count($replacements)) {
            foreach ($replacements as $key => $value) {
                $content = str_replace($key, $value, $content);
            }
        }
        return $content;
    }


}
