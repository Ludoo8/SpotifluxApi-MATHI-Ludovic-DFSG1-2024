<?php

namespace App\Controller;


use App\Entity\Track;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/track")
 */
class TrackController extends AbstractController
{
    /**
     * @Route("/{id}", name="get_track", methods={"GET"})
     */
    public function getTrack(Track $track): JsonResponse
    {
        return new JsonResponse([
            'id' => $track->getId(),
            'name' => $track->getName(),
        ]);
    }

    /**
     * @Route("", name="create_track", methods={"POST"})
     */
    public function createTrack(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $track = new Track();
        $track->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($track);
        $entityManager->flush();

        return new JsonResponse(['id' => $track->getId()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="update_track", methods={"PUT"})
     */
    public function updateTrack(Track $track, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $name = $requestData['name'] ?? null;

        if (!$name) {
            return new JsonResponse(['error' => 'Name requis'], Response::HTTP_BAD_REQUEST);
        }

        $track->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", name="delete_track", methods={"DELETE"})
     */
    public function deleteTrack(Track $track): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($track);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
#wtf c'est quoi POSTMAN ?

