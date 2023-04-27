<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Service;

use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Nuvola\OAuth2AuthenticatorBundle\Token\Token;
use Nuvola\OAuth2AuthenticatorBundle\Token\TokenFactoryInterface;

final readonly class IntrospectService implements IntrospectServiceInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $clientId,
        private string $clientSecret,
        private string $endpoint,
        private TokenFactoryInterface $tokenFactory,
    ) {
    }

    public function itrospect(string $token): Token
    {
        $httpOptions = new HttpOptions();
        $httpOptions
            ->setAuthBasic($this->clientId, $this->clientSecret)
            ->setBody([
                'token' => $token,
            ])
        ;

        try {
            $data = $this->httpClient->request('POST', $this->endpoint, $httpOptions->toArray())->toArray();
        } catch (ExceptionInterface|TransportExceptionInterface $e) {
            throw new \RuntimeException($e->getMessage(), 0, $e); // TODO: custom exception
        }

        return $this->tokenFactory->create($token, $data);
    }
}
