<?php

/*
 * (c) Phu Tran <viscafcb96@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Hasura\Security\Authenticator;

use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class HasuraJsonLoginAuthenticator extends JsonLoginAuthenticator
{
  private $options;

  public function __construct(HttpUtils $httpUtils, UserProviderInterface $userProvider, ?AuthenticationSuccessHandlerInterface $successHandler = null, ?AuthenticationFailureHandlerInterface $failureHandler = null, array $options = [], ?PropertyAccessorInterface $propertyAccessor = null)
  {
    $this->options = $options;
    parent::__construct($httpUtils, $userProvider, $successHandler, $failureHandler, $options, $propertyAccessor ?: PropertyAccess::createPropertyAccessor());
  }

  public function supports(Request $request): ?bool
  {
    $support = parent::supports($request);

    $data = json_decode($request->getContent(), true);
    $actionName = $data['action']['name'] ?? null;

    if (!$actionName) {
      $support = false;
    }

    if ($actionName && $actionName !== $this->options['action_name']) {
      $support = false;
    }

    return $support;
  }
}
