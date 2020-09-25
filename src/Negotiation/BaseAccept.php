<?php

namespace Negotiation;

abstract class BaseAccept
{
    /**
     * @var float
     */
    private $quality = 1.0;

    /**
     * @var string
     */
    private $normalized;

    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $value
     */
    public function __construct(?string $value)
    {
        list($type, $parameters) = $this->parseParameters($value);

        if (isset($parameters['q'])) {
            $this->quality = (float) $parameters['q'];
            unset($parameters['q']);
        }

        $type = trim(strtolower($type));

        $this->value      = $value;
        $this->normalized = $type . ($parameters ? "; " . $this->buildParametersString($parameters) : '');
        $this->type       = $type;
        $this->parameters = $parameters;
    }

    public function getNormalizedValue(): string
    {
        return $this->normalized;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuality(): float
    {
        return $this->quality;
    }

    /**
     * @return mixed[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return string|null
     */
    public function getParameter(string $key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }

    /**
     * @param string $key
     */
    public function hasParameter(string $key): bool
    {
        return isset($this->parameters[$key]);
    }

    /**
     *
     * @param  string $acceptPart
     * @return string[][]
     */
    private function parseParameters(?string $acceptPart): array
    {
        $parts = explode(';', $acceptPart);
        $type  = array_shift($parts);

        $parameters = [];
        foreach ($parts as $part) {
            $part = explode('=', $part);

            if (2 !== count($part)) {
                continue; // TODO: throw exception here?
            }

            $key = strtolower(trim($part[0])); // TODO: technically not allowed space around "=". throw exception?
            $parameters[$key] = trim($part[1], ' "');
        }

        return [ $type, $parameters ];
    }

    private function buildParametersString(array $parameters): string
    {
        $parts = [];

        ksort($parameters);
        foreach ($parameters as $key => $val) {
            $parts[] = sprintf('%s=%s', $key, $val);
        }

        return implode('; ', $parts);
    }
}
