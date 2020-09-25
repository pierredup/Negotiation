<?php

namespace Negotiation;

use Negotiation\Exception\InvalidMediaType;

final class Accept extends BaseAccept implements AcceptHeader
{
    /**
     * @var string
     */
    private $basePart;

    /**
     * @var string
     */
    private $subPart;

    public function __construct(string $value)
    {
        parent::__construct($value);

        if ($this->type === '*') {
            $this->type = '*/*';
        }

        $parts = explode('/', $this->type);

        if (count($parts) !== 2 || !$parts[0] || !$parts[1]) {
            throw new InvalidMediaType();
        }

        $this->basePart = $parts[0];
        $this->subPart  = $parts[1];
    }

    public function getSubPart(): string
    {
        return $this->subPart;
    }

    public function getBasePart(): string
    {
        return $this->basePart;
    }
}
