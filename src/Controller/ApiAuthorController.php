<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\NationalityRepository;
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

class ApiAuthorController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home(): Response
    {
        return $this->render('app/index.html.twig');
    }
    /**
     * @Route("/api/authors", name="api_authors", methods={"GET"})
     */
    public function list(AuthorRepository $repo, SerializerInterface $serializer): Response
    {
        $authors = $repo->findAll();
        $result = $serializer->serialize(
            $authors,
            'json',
            [
                'groups' => ['listAuthorFull']
            ]
        );
        return new JsonResponse($result, 200, [], true);
    }

    /**
     * @Route("/api/authors/{id}", name="api_author_show", methods={"GET"})
     */
    public function show(Author $author, SerializerInterface $serializer): Response
    {   
        $result = $serializer->serialize(
            $author,
            'json',
            [
                'groups'=>['listAuthorSimple']
            ]
        );
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/authors", name="api_author_create", methods={"POST"})
     */
    public function create(SerializerInterface $serializer, EntityManagerInterface $em, Request $request, 
                            ValidatorInterface $validator, NationalityRepository $repoNat): Response
    {
        $data        = $request->getContent();
        $dataTab     = $serializer->decode($data,'json');
        $author      = new Author;
        $nationality = $repoNat->find($dataTab["nationality"]["id"]);
        $author = $serializer->deserialize(
            $data,
            Author::class,
            'json',
            ['object_to_populate'=> $author]      
        );

        $author->setNationality($nationality);
        
        $error = $validator->validate($author);
        if(count($error)){
            $errorJson=$serializer->serialize($error, 'json');
            return  new JsonResponse($errorJson, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($author);
        $em->flush();

        return new JsonResponse(
            "L'auteur as bien été crée", 
            Response::HTTP_CREATED,
            ['location' => $this->generateUrl("api_author_show", ['id' => $author->getId(), UrlGeneratorInterface::ABSOLUTE_URL])],
            true);
    }

    /**
     * @Route("/api/authors/{id}", name="api_author_update", methods={"PUT"})
     */
    public function update(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, 
                            Author $author, ValidatorInterface $validator, NationalityRepository $repoNat): Response
    {
        $data        = $request->getContent();
        $dataTab     = $serializer->decode($data,'json');
        $nationality = $repoNat->find($dataTab['nationality']['id']);

        $serializer->deserialize(
            $data,
            Author::class,
            'json',
            ['object_to_populate'=> $author]
        );

        $author->setNationality($nationality);

        $error = $validator->validate($author);
        if(count($error)){
            $errorJson=$serializer->serialize($error, 'json');
            return  new JsonResponse($errorJson, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($author);
        $em->flush();

        return new JsonResponse("L'auteur a bien été modifier", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/authors/{id}", name="api_author_delete", methods={"DELETE"})
     */
    public function delete(Author $author, EntityManagerInterface $em): Response
    {   
        $em->remove($author);
        $em->flush();

        return new JsonResponse("L'auteur a bien été supprimer", Response::HTTP_OK, [], false);
    }
}
