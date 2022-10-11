<?php

namespace App\Core\Validators;

abstract class AbstractValidator
{
    /**
     * The validator instance.
     *
     * @var object
     */
    protected $validator;

    /**
     * Data to be validated.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Validation Rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validation Messages.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Validation errors.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Set data to validate.
     *
     * @param array $data
     *
     * @return self
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Pass the data and the rules to the validator.
     *
     * @return bool
     */
    abstract public function passes();

    /**
     * Return errors.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }
}
