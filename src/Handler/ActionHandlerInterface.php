<?php
/*
 * (c) Minh Vuong <vuongxuongminh@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace Hasura\Handler;

interface ActionHandlerInterface
{
    public function handle(string $action, array | object $input, array $sessionVariables): array | object;
}
