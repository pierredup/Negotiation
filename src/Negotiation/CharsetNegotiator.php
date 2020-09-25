<?php

namespace Negotiation;

class CharsetNegotiator extends AbstractNegotiator
{
    /**
     * {@inheritdoc}
     */
    protected function acceptFactory(string $accept): AcceptHeader
    {
        return new AcceptCharset($accept);
    }
}
