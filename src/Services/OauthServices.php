<?php

namespace Labstag\Services;

use Labstag\Lib\GenericProviderLib;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OauthServices
{

    /**
     * @var array
     */
    protected $configProvider;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router    = $container->get('router');
        $this->setConfigProvider();
    }

    public function getIdentity($data, $oauth)
    {
        switch ($oauth) {
            case 'gitlab':
            case 'github':
            case 'discord':
                return $data['id'];
            case 'google':
                return $data['sub'];
            case 'bitbucket':
                return $data['uuid'];
            default:
                return '';
        }
    }

    public function setProvider($clientName)
    {
        if (isset($this->configProvider[$clientName])) {
            return $this->initProvider($clientName);
        }
    }

    protected function setConfigProvider()
    {
        $this->configProvider = [
            'gitlab'    => [
                'params'         => [
                    'urlAuthorize'            => 'https://gitlab.com/oauth/authorize',
                    'urlAccessToken'          => 'https://gitlab.com/oauth/token',
                    'urlResourceOwnerDetails' => 'https://gitlab.com/api/v4/user',
                ],
                'redirect'       => 1,
                'scopeseparator' => ' ',
                'scopes'         => ['read_user'],
            ],
            'bitbucket' => [
                'params' => [
                    'urlAuthorize'            => 'https://bitbucket.org/site/oauth2/authorize',
                    'urlAccessToken'          => 'https://bitbucket.org/site/oauth2/access_token',
                    'urlResourceOwnerDetails' => 'https://api.bitbucket.org/2.0/user',
                ],
            ],
            'github'    => [
                'params' => [
                    'urlAuthorize'            => 'https://github.com/login/oauth/authorize',
                    'urlAccessToken'          => 'https://github.com/login/oauth/access_token',
                    'urlResourceOwnerDetails' => 'https://api.github.com/user',
                ],
            ],
            'discord'   => [
                'params'         => [
                    'urlAuthorize'            => 'https://discordapp.com/api/v6/oauth2/authorize',
                    'urlAccessToken'          => 'https://discordapp.com/api/v6/oauth2/token',
                    'urlResourceOwnerDetails' => 'https://discordapp.com/api/v6/users/@me',
                ],
                'scopeseparator' => ' ',
                'scopes'         => [
                    'identify',
                    'email',
                    'connections',
                    'guilds',
                    'guilds.join',
                ],
            ],
            'google'    => [
                'params'         => [
                    'urlAuthorize'            => 'https://accounts.google.com/o/oauth2/v2/auth',
                    'urlAccessToken'          => 'https://www.googleapis.com/oauth2/v4/token',
                    'urlResourceOwnerDetails' => 'https://openidconnect.googleapis.com/v1/userinfo',
                ],
                'redirect'       => 1,
                'scopeseparator' => ' ',
                'scopes'         => [
                    'openid',
                    'email',
                    'profile',
                ],
            ],
        ];
    }

    protected function initProvider($clientName)
    {
        $config = (isset($this->configProvider[$clientName])) ? $this->configProvider[$clientName] : [];
        if (isset($config['redirect'])) {
            $config['params']['redirectUri'] = $this->router->generate(
                'connect_check',
                ['oauthCode' => $clientName],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
        }

        $code                             = strtoupper($clientName);
        $config['params']['clientId']     = getenv('OAUTH_'.$code.'_ID');
        $config['params']['clientSecret'] = getenv('OAUTH_'.$code.'_SECRET');

        $provider = new GenericProviderLib(
            $config['params']
        );
        if (isset($config['scopes'])) {
            $provider->setDefaultScopes($config['scopes']);
        }

        if (isset($config['scopeseparator'])) {
            $provider->setScopeSeparator($config['scopeseparator']);
        }

        return $provider;
    }
}