<?php
/*
 * (c) Minh Vuong <vuongxuongminh@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace Hasura\ApiClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client
{
    private HttpClientInterface $httpClient;

    public function __construct(string $baseUri, string $adminSecret = null, array $httpClientOptions = [])
    {
        $httpClientOptions['base_uri'] = $baseUri;

        if ($adminSecret) {
            $httpClientOptions['headers']['X-Hasura-Admin-Secret'] = $adminSecret;
        }

        $this->httpClient = HttpClient::create($httpClientOptions);
    }

    public function metadata(): MetadataApi
    {
        return new MetadataApi($this->httpClient);
    }
}
