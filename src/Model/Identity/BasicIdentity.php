<?php

namespace ddd\Model\Identity;

use ddd\Model\Identity\Identity;
use ddd\Model\Identity\Exception\IdentityValueException;
use ddd\Utils\Equals;

/**
 * Represents an identity.
 *
 * @author cdejoye
 */
class BasicIdentity implements Identity
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * Creates an identity from a value.
     *
     * @param mixed $value
     *
     * @throws IdentityValueException
     */
    public static function from($value)
    {
        return new static($value);
    }

    /**
     * @throws \LogicException
     */
    private function __clone()
    {
        throw new \LogicException('Cloning a value object ? Weird...');
    }

    /**
     * {@inheritdoc}
     */
    public function equals($value): bool
    {
        if ($value instanceof Equals) {
            return $value->equals($this->value());
        }

        return $value === $this->value();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }

    /**
     * Constructs an identity.
     *
     * @param mixed $value
     *
     * @throws IdentityValueException
     */
    protected function __construct($value)
    {
        static::assertThatItsAValidIdentityValue($value);

        $this->value = $value;
    }

    /**
     * Asserts that a value is a valid identity value.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @throws IdentityValueException
     */
    protected static function assertThatItsAValidIdentityValue($value): void
    {
        if (!$value) {
            throw IdentityValueException::becauseAnIndentityCantBeEmpty();
        }

        self::assertThatAValueIsConvertibleIntoAString($value);
    }

    /**
     * Asserts that a value is convertible into a string.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @throws IdentityValueException
     */
    protected static function assertThatAValueIsConvertibleIntoAString($value)
    {
        set_error_handler(
            function (int $errno, string $errstr) {
                throw IdentityValueException::becauseAnIdentityMustBeConvertibleIntoAString();
            }
        );

        try {
            (string) $value;
        } finally {
            restore_error_handler();
        }
    }
}
