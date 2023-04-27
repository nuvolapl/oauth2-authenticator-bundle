<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Repository;

use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class UserRepository implements UserRepositoryInterface, AuthBearerAwareInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private readonly string $endpoint,
    ) {
    }

    public function setAuthBearer(string $token): void
    {
        $options = new HttpOptions();
        $options->setAuthBearer($token);

        $this->client = $this->client->withOptions($options->toArray());
    }

    public function getUserInfo(): array
    {
        try {
            return $this->client->request('GET', $this->endpoint)->toArray();
        } catch (ExceptionInterface|TransportExceptionInterface $e) {
            throw new \RuntimeException($e->getMessage(), 0, $e); // TODO: custom exception
        }
    }
}
