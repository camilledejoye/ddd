<?php

namespace ddd\Model\Entity;

/**
 * Interface for all objects that can be identifies.
 * 
 * @author cdejoye
 */
interface Identifies
{
    /**
     * @return mixed The identity of the object.
     */
    public function id();

}