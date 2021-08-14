<?php

/*
 * (c) Phu Tran <viscafcb96@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hasura\Security\Factory;


use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\JsonLoginFactory;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * HasuraJsonLoginFactory creates services for Hasura action login authentication.
 *
 */
class HasuraJsonLoginFactory extends JsonLoginFactory
{
    public function __construct()
    {
        parent::__construct();

        $this->addOption('username_path', 'input.object.username');
        $this->addOption('password_path', 'input.object.password');
        $this->addOption('action_name', 'action_login');
        $this->defaultFailureHandlerOptions = [];
        $this->defaultSuccessHandlerOptions = [];
    }

    public function getKey()
    {
        return 'hasura_json_login';
    }

    public function createAuthenticator(ContainerBuilder $container, string $firewallName, array $config, string $userProviderId)
    {
        $authenticatorId = 'security.authenticator.hasura_json_login.'.$firewallName;
        $options = array_intersect_key($config, $this->options);
        $container
            ->setDefinition($authenticatorId, new ChildDefinition('security.authenticator.hasura_json_login'))
            ->replaceArgument(1, new Reference($userProviderId))
            ->replaceArgument(2, isset($config['success_handler']) ? new Reference($this->createAuthenticationSuccessHandler($container, $firewallName, $config)) : null)
            ->replaceArgument(3, isset($config['failure_handler']) ? new Reference($this->createAuthenticationFailureHandler($container, $firewallName, $config)) : null)
            ->replaceArgument(4, $options);

        return $authenticatorId;
    }
}
