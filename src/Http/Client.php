<?php

/*
 * This file is part of the BenGorFile package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Drupal\bengor_file\Http;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;

/**
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Client
{
    private $client;
    private $url;

    public function __construct(HttpClient $client, string $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    public function fileOfId(string $id) : array
    {
        try {
            $response = $this->client->sendRequest(
                new Request(
                    'GET',
                    $this->url($id),
                    ['Content-Type' => 'application/json']
                )
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                return $exception->getResponse();
            }

            throw new $exception;
        }
    }

    private function url(string $id) : string
    {
        return sprintf($this->url, $id);
    }
}
