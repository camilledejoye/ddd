<?php

namespace ddd\Model\Identity;

interface SelfGeneratedIdentity
{
    /**
     * Generates a new Identity.
     *
     * @return self
     */
    public static function generate();
}
