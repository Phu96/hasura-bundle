<?php

/*
 * (c) Phu Tran <viscafcb96@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Hasura\Security\Authenticator\HasuraJsonLoginAuthenticator;

return static function (ContainerConfigurator $configurator) {
  $configurator
      ->services()
        ->set('security.authenticator.hasura_json_login', HasuraJsonLoginAuthenticator::class)
            ->parent('security.authenticator.json_login')
  ;
};

