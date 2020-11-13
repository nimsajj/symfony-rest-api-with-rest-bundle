<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Response;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;

class SecurityController extends AbstractFOSRestController
{
    private $client_manager;

    public function __construct(ClientManagerInterface $client_manager)
    {
        $this->client_manager = $client_manager;
    }
    /**
     * Create Client.
     * @FOSRest\Post("/client")
     *
     * @return Response
     */
    public function Authentication(Request $request): View
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['redirect-uri']) || empty($data['grant-type'])) {
            return View::create($data, Response::HTTP_NOT_FOUND);
        }

        $client = $this->client_manager->createClient();
        $client->setRedirectUris([$data['redirect-uri']]);
        $client->setAllowedGrantTypes([$data['grant-type']]);

        $this->client_manager->updateClient($client);

        $rows = [
            'client_id' => $client->getPublicId(),
            'client_secret' => $client->getSecret()
        ];

        return View::create($rows, Response::HTTP_CREATED);
    }
}
