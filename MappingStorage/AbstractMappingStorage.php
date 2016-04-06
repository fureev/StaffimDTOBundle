<?php

namespace Staffim\DTOBundle\MappingStorage;

abstract class AbstractMappingStorage implements MappingStorageInterface
{
    /**
     * @param string $key
     * @return array
     */
    abstract protected function getRawFields($key);

    /**
     * return array
     */
    public function getRelations()
    {
        return $this->getFields('relations');
    }

    /**
     * @return array
     */
    public function getFieldsToShow()
    {
        return $this->getFields('fields');
    }

    /**
     * @return array
     */
    public function getFieldsToHide()
    {
        return $this->getFields('hideFields', false);
    }

    /**
     * @param string $key
     * @return array
     */
    private function getFields($key, $expandPath = true)
    {
        return $this->compileFields($key, $expandPath);
    }

    /**
     * @param string $key
     * @param bool $expandPath
     * @return array
     */
    private function compileFields($key, $expandPath = true)
    {
        $rawValues = $this->getRawFields($key);

        if ($expandPath) {
            $result = [];
            foreach ($rawValues as $path) {
                $path = explode('.', $path);
                $value = '';
                foreach ($path as $item) {
                    $value .= $item;
                    $result[] = $value;
                    $value .= '.';
                }

            }
            $result = array_values(array_unique($result));
        } else {
            $result = $rawValues;
        }

        return $result;
    }
}
