<?php

namespace App\Controller;


use App\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/{id}", name="get_album", methods={"GET"})
     */
    public function getAlbum(Album $album): JsonResponse
    {
        return new JsonResponse([
            'id' => $album->getId(),
            'name' => $album->getName(),
        ]);
    }

    /**
     * @Route("", name="create_album", methods={"POST"})
     */
    public function createAlbum(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $album = new Album();
        $album->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($album);
        $entityManager->flush();

        return new JsonResponse(['id' => $album->getId()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="update_album", methods={"PUT"})
     */
    public function updateAlbum(Album $album, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $album->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", name="delete_album", methods={"DELETE"})
     */
    public function deleteAlbum(Album $album): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($album);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}

#wtf c'est quoi POSTMAN ?

