<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Security;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Nuvola\OAuth2AuthenticatorBundle\EventDispatcher\Event\TokenVerifiedEvent;
use Nuvola\OAuth2AuthenticatorBundle\Service\IntrospectServiceInterface;

final class OAuth2Authenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly IntrospectServiceInterface $introspectService,
        private readonly ?EventDispatcherInterface $eventDispatcher = null,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return str_starts_with((string) $request->headers->get('Authorization', ''), 'Bearer');
    }

    public function authenticate(Request $request): Passport
    {
        $authorization = $request->headers->get('Authorization');

        if (null === $authorization) {
            throw new CustomUserMessageAuthenticationException('Authorization header cannot be empty.');
        }

        try {
            $token = $this->introspectService->itrospect(substr($authorization, strlen('Bearer ')));
        } catch (\RuntimeException $e) {
            throw new TokenNotFoundException('Invalid token.', 0, $e);
        }

        $event = $this->eventDispatcher?->dispatch(new TokenVerifiedEvent($token));

        return new SelfValidatingPassport(
            new UserBadge(
                $token->userIdentifier,
                function (string $identifier) use ($event) {
                    if ($event && $event->isUserSet()) {
                        return $event->getUser();
                    }

                    return null;
                }
            ),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
