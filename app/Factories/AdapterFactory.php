<?php

namespace App\Factories;

use App\Models\Source;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

class AdapterFactory
{

    /**
     * Returns the Adapter for the Source
     *
     * @param Source $source
     * @return AbstractArticleAdapter|AbstractAuthorAdapter|AbstractCategoryAdapter|AbstractClient|object
     * @throws \Exception
     */
    public static function create(Source $source, string $adapterName)
    {
        $integration = Str::studly($source->name);
        $adapterName = ucwords($adapterName);
        if ($adapterName == 'Client') {
            $fileName = $adapterName;
        } else {
            $fileName = $adapterName.'Adapter';
        }
        $target = "\App\Sources\\$integration\\$fileName";
        try {
            $reflector = new ReflectionClass($target);

            if ($reflector->isInstantiable()) {
                return $reflector->newInstanceArgs([$source]);
            }

        } catch (ReflectionException $exception) {
            //Just catching it here so we can add additional logs below and not have to repeat the code
        }

        throw new \Exception("Unknown source for $fileName Adapter.");
    }
}
