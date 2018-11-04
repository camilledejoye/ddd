<?php

namespace ddd\Identity;

interface GeneratesIdentities
{
    /**
     * Generates an identity.
     *
     * @return IdentifiesAnAggrate
     */
    public static function generate();
}
