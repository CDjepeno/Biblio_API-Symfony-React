<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiGenreController extends AbstractController
{
    /**
     * @Route("/api/genres", name="api_genres", methods={"GET"})
     */
    public function list(GenreRepository $repo, SerializerInterface $serializer): Response
    {
        $genres = $repo->findAll();
        $result = $serializer->serialize(
            $genres,
            'json',
            [
                'groups' => ['listGenreFull']
            ]
        );
        return new JsonResponse($result, 200, [], true);
    }

    /**
     * @Route("/api/genres/{id}", name="api_genre_show", methods={"GET"})
     */
    public function show(Genre $genre, SerializerInterface $serializer): Response
    {   
        $result = $serializer->serialize(
            $genre,
            'json',
            [
                'groups'=>['listGenreShow']
            ]
        );
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/genres", name="api_genre_create", methods={"POST"})
     */
    public function create(SerializerInterface $serializer, EntityManagerInterface $em, 
                            Request $request, ValidatorInterface $validator): Response
    {
        $data  = $request->getContent();

        $genre = $serializer->deserialize(
            $data,
            Genre::class,
            'json'      
        );
        
        $error = $validator->validate($genre);
        if(count($error)){
            $errorJson=$serializer->serialize($error, 'json');
            return  new JsonResponse($errorJson, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($genre);
        $em->flush();

        return new JsonResponse(
            "Le genre as bien été ajouter", 
            Response::HTTP_CREATED,
            ['location' => $this->generateUrl("api_genre_show", ['id' => $genre->getId(), UrlGeneratorInterface::ABSOLUTE_URL])],
            true);
    }

    /**
     * @Route("/api/genres/{id}", name="api_genre_update", methods={"PUT"})
     */
    public function update(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
                             Genre $genre, ValidatorInterface $validator): Response
    {
        $data = $request->getContent();

        $serializer->deserialize(
            $data,
            Genre::class,
            'json',
            ['object_to_populate'=> $genre]
        );

        $error = $validator->validate($genre);
        if(count($error)){
            $errorJson=$serializer->serialize($error, 'json');
            return  new JsonResponse($errorJson, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($genre);
        $em->flush();

        return new JsonResponse("Le genre a bien été modifier", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/genres/{id}", name="api_genre_delete", methods={"DELETE"})
     */
    public function delete(Genre $genre, EntityManagerInterface $em): Response
    {   
        $em->remove($genre);
        $em->flush();

        return new JsonResponse("Le genre a bien été supprimer", Response::HTTP_OK, [], false);
    }
}
