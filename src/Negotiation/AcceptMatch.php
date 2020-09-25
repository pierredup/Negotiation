<?php

namespace Negotiation;

final class AcceptMatch
{
    /**
     * @var float
     */
    public $quality;

    /**
     * @var int
     */
    public $score;

    /**
     * @var int
     */
    public $index;

    public function __construct(float $quality, int $score, int $index)
    {
        $this->quality = $quality;
        $this->score   = $score;
        $this->index   = $index;
    }

    /**
     * @param AcceptMatch $a
     * @param AcceptMatch $b
     */
    public static function compare(AcceptMatch $a, AcceptMatch $b): int
    {
        if ($a->quality !== $b->quality) {
            return $a->quality > $b->quality ? -1 : 1;
        }

        if ($a->index !== $b->index) {
            return $a->index > $b->index ? 1 : -1;
        }

        return 0;
    }

    /**
     * @param mixed[]   $carry reduced array
     * @param AcceptMatch $match match to be reduced
     *
     * @return AcceptMatch[]
     */
    public static function reduce(array $carry, AcceptMatch $match): array
    {
        if (!isset($carry[$match->index]) || $carry[$match->index]->score < $match->score) {
            $carry[$match->index] = $match;
        }

        return $carry;
    }
}
