<?php
/*
 * (c) Minh Vuong <vuongxuongminh@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace VXM\Hasura\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use VXM\Hasura\Exception\HttpExceptionInterface;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof HttpExceptionInterface) {
            return;
        }

        $response = new JsonResponse(
            [
                'message' => $exception->getMessage(),
                'code' => $exception->getMessageCode(),
            ],
            $exception->getStatusCode()
        );

        $event->setResponse($response);
    }
}
