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

use Http\Client\HttpClient;
use Http\Message\MessageFactory;

/**
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class Client
{
    private $client;
    private $messageFactory;
    private $url;

    public function __construct(HttpClient $client, MessageFactory $messageFactory, string $url)
    {
        $this->client = $client;
        $this->url = $url;
        $this->messageFactory = $messageFactory;
    }

    public function fileOfId(string $id) : array
    {
        $request = $this->messageFactory->createRequest('GET', $this->url($id), [
            'Content-Type' => 'application/json',
        ]);
        $response = $this->client->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function url(string $id) : string
    {
        return sprintf($this->url, $id);
    }
}
