<?php

namespace App\Controller;


use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/artists")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/{id}", name="get_artist", methods={"GET"})
     */
    public function getArtist(Artist $artist): JsonResponse
    {
        return new JsonResponse([
            'id' => $artist->getId(),
            'name' => $artist->getName(),
        ]);
    }

    /**
     * @Route("", name="create_artist", methods={"POST"})
     */
    public function createArtist(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $artist = new Artist();
        $artist->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($artist);
        $entityManager->flush();

        return new JsonResponse(['id' => $artist->getId()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="update_artist", methods={"PUT"})
     */
    public function updateArtist(Artist $artist, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $artist->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", name="delete_artist", methods={"DELETE"})
     */
    public function deleteArtist(Artist $artist): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($artist);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}

#wtf c'est quoi POSTMAN ?

