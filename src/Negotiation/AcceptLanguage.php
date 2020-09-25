<?php

namespace Negotiation;

use Negotiation\Exception\InvalidLanguage;

final class AcceptLanguage extends BaseAccept implements AcceptHeader
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $script;

    /**
     * @var string
     */
    private $region;

    public function __construct(?string $value)
    {
        parent::__construct($value);

        $parts = explode('-', $this->type);

        if (2 === count($parts)) {
            $this->language = $parts[0];
            $this->region   = $parts[1];
        } elseif (1 === count($parts)) {
            $this->language = $parts[0];
        } elseif (3 === count($parts)) {
            $this->language = $parts[0];
            $this->script   = $parts[1];
            $this->region   = $parts[2];
        } else {
            // TODO: this part is never reached...
            throw new InvalidLanguage();
        }
    }

    public function getSubPart(): ?string
    {
        return $this->region;
    }

    public function getBasePart(): ?string
    {
        return $this->language;
    }
}
