<?php

namespace App\Security;

use App\Entity\User;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class KeycloakAuthenticator
 */
class KeycloakAuthenticator extends SocialAuthenticator
{

    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function start(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            '/oauth/login', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'oauth_check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getKeycloakClient());
    }

    public function getUser($credentials, \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider)
    {
        $keycloakUser = $this->getKeycloakClient()->fetchUserFromToken($credentials);
        //dd($keycloakUser->toArray()['preferred_username']);
        //existing user ?
        $existingUser = $this
                            ->em
                            ->getRepository(User::class)
                            ->findOneBy(['KeycloakId' => $keycloakUser->getId()]);

        if ($existingUser) {
            return $existingUser;
        }
        // if user exist but never connected with keycloak
        $email = $keycloakUser->getEmail();
        /** @var User $userInDatabase */
        $userInDatabase = $this->em->getRepository(User::class)
            ->findOneBy(['email' => $email]);
        if($userInDatabase) {
            $userInDatabase->setKeycloakId($keycloakUser->getId());
            $this->em->persist($userInDatabase);
            $this->em->flush();
            return $userInDatabase;
        }
        //user not exist in database
        $user = new User();
        $user->setKeycloakId($keycloakUser->getId());
        $user->setEmail($keycloakUser->getEmail());
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('');
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    public function onAuthenticationFailure(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, string $providerKey)
    {
        // change "app_homepage" to some route in your app
        $targetUrl = $this->router->generate('dashboard');

        return new RedirectResponse($targetUrl);
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\Provider\KeycloakClient
     */
    private function getKeycloakClient()
    {
        return $this->clientRegistry->getClient('keycloak');
    }
}

