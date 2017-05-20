<?php

namespace ddd\Model\Identity;

use ddd\Utility\Equals;

/**
 * Represents an identity.
 * 
 * @author cdejoye
 */
interface Identity extends Equals
{
    
    /**
     * Generates an identity.
     * 
     * @retun static The new identity.
     */
    public static function generate();
    
    /**
     * Creates a new identity from another one.
     * 
     * @param static $idToCopy The identity to copy.
     * 
     * @return static The new identity.
     */
    public static function copy($idToCopy);
    
    /**
     * Creates a new identity from a value.
     * 
     * @param mixed $value The desired value for the identity, must be convertible to string.
     * 
     * @return static The new identity.
     */
    public static function from($value);
    
    /**
     * Clones an identity
     */
    public function __clone();
    
    /**
     * Gets the value of an identity.
     *
     * @return mixed The entity's identity.
     */
    public function value();

    /**
     * The string representation of an entity's identity.
     *
     * @return string The string representation of the identity.
     */
    public function __toString();

}
