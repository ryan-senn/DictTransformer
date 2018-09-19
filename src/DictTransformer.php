<?php

namespace DictTransformer;

use DictTransformer\Exceptions\InvalidResourceException;
use DictTransformer\Exceptions\MissingTransformException;
use DictTransformer\Exceptions\MissingKeyException;
use DictTransformer\Exceptions\MissingIncludeException;
use DictTransformer\Exceptions\MissingGetIdException;

/**
 * @package DictTransformer
 */
class DictTransformer
{

    /**
     * @var array
     */
    private $entities = [];

    /**
     * @param Item|Collection|NullableItem $resource
     * @param array                        $includes
     *
     * @return array
     * @throws InvalidResourceException
     */
    public function transform($resource, array $includes = [])
    {
        $keys = $this->transformResource($resource, $includes);

        $entities = $this->entities;
        $this->entities = [];

        return [
            'result'   => $keys,
            'entities' => $entities,
        ];
    }

    /**
     * @param Item|Collection $resource
     * @param array           $includes
     *
     * @return array
     * @throws InvalidResourceException
     */
    private function transformResource($resource, array $includes = [])
    {
        switch (true) {

            case $resource instanceof Item:

                return $this->transformItem($resource, $includes);

            case $resource instanceof Collection:

                return $this->transformCollection($resource, $includes);

            case $resource instanceof NullableItem:

                return $this->transformNullableItem($resource, $includes);

            default:

                throw new InvalidResourceException;
        }
    }

    /**
     * @param Item  $item
     * @param array $includes
     *
     * @return mixed
     * @throws MissingGetIdException
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     */
    private function transformItem(Item $item, array $includes = [])
    {
        $entity = $item->getEntity();
        $transformer = $item->getTransformer();

        $key = $this->transformEntity($entity, $transformer, $includes);

        return $key;
    }

    private function transformNullableItem(NullableItem $item, array $includes = [])
    {
        $entity = $item->getEntity();
        $transformer = $item->getTransformer();

        $key = $key = $this->transformEntity($entity, $transformer, $includes, true);

        return $key;
    }

    /**
     * @param Collection $collection
     * @param array      $includes
     *
     * @return array
     * @throws MissingGetIdException
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     */
    private function transformCollection(Collection $collection, array $includes = [])
    {
        $entities = $collection->getEntities();
        $transformer = $collection->getTransformer();

        $keys = [];

        foreach ($entities as $entity) {

            $key = $this->transformEntity($entity, $transformer, $includes);

            $keys[] = $key;
        }

        return $keys;
    }

    /**
     * @param       $entity
     * @param       $transformer
     * @param array $includes
     * @param bool  $nullable
     *
     * @return mixed
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     * @throws InvalidResourceException
     * @throws MissingGetIdException
     */
    private function transformEntity($entity, $transformer, array $includes = [], $nullable = false)
    {
        if (!method_exists($transformer, 'transform')) {
            throw new MissingTransformException;
        }

        if (!$this->hasKeyConstant($transformer)) {
            throw new MissingKeyException;
        }

        if ($nullable && $entity == null) {
            return null;
        }

        if (!method_exists($entity, "getId")) {
            throw new MissingGetIdException();
        }

        $id = $entity->getId();

        if (isset($this->entities[$transformer::KEY][$id])) {
            $data = $this->entities[$transformer::KEY][$id];
        }
        else {
            $data = $transformer->transform($entity);
            $data['id'] = $id;
        }

        foreach ($includes as $include) {

            $parsedIncludeString = $this->parseIncludeString($include);

            $current = $parsedIncludeString['current'];
            $rest = $parsedIncludeString['rest'];

            if (!method_exists($transformer, $current)) {
                throw new MissingIncludeException(get_class($transformer), $current);
            }

            $resource = $transformer->{$current}($entity);

            $data[$current] = $this->transformResource($resource, $rest);
        }

        $this->entities[$transformer::KEY][$id] = isset($this->entities[$transformer::KEY][$id])
            ? array_merge($this->entities[$transformer::KEY][$id], $data)
            : $data;

        return $id;
    }

    /**
     * @param string $includeString
     *
     * @return array
     */
    private function parseIncludeString(string $includeString)
    {
        $position = strpos($includeString, '.');

        if ($position !== false) {

            return [
                'current' => substr($includeString, 0, $position),
                'rest'    => [substr($includeString, $position + 1)],
            ];
        }

        return [
            'current' => $includeString,
            'rest'    => [],
        ];
    }

    /**
     * @param $transformer
     *
     * @return bool
     */
    private function hasKeyConstant($transformer)
    {
        $transformerName = get_class($transformer);

        return defined("$transformerName::KEY");
    }
}