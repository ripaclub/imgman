<?php

namespace ImgManLibrary\Core\Adapter;

trait AdapterAwareTrait
{
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }


} 