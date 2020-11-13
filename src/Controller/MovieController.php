<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Movie;
use App\Repository\MovieRepository;

/** @Route("/api", name="api_") */
class MovieController extends AbstractFOSRestController
{
    private $movieRepository;

    function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * Lists all Movies.
     * @Rest\Get("/movies", name="get_all_movie")
     * 
     * @return View
     */
    public function getAllMovie(): View
    {
        $movies = $this->movieRepository->findAll();

        return View::create($movies, response::HTTP_OK);
    }

    /**
     * Get a Movie.
     * @Rest\Get("/movies/{id}", name="get_movie")
     * 
     * @return View
     */
    public function getMovie(int $id): View
    {
        $movie = $this->movieRepository->findBy(['id' => $id]);

        if (!$movie) {
            return View::create(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        return View::create($movie, Response::HTTP_OK);
    }

    /**
     * Add a Movie.
     * @Rest\Post("/movies", name="add_movie")
     * 
     * @return View
     */
    public function addMovie(Request $request, ValidatorInterface $validator): View
    {
        $data = json_decode($request->getContent(), true);

        $movie = new Movie();
        $movie
            ->setIsan($data['isan'])
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setRuntime($data['runtime'])
            ->setRealeaseAt(new \DateTime($data['realeaseAt']));

        $errors = $validator->validate($movie);
        if (count($errors) > 0) {

            return View::create($errors, Response::HTTP_ACCEPTED);
        }

        $movieCreated = $this->movieRepository->save($movie);

        return View::create($movieCreated, Response::HTTP_CREATED);
    }

    /**
     * Update a Movie.
     * @Rest\Put("/movies/{id}", name="update_movie")
     * 
     * @return View
     */
    public function updateCustomer(int $id, Request $request, ValidatorInterface $validator): View
    {
        $data = json_decode($request->getContent(), true);

        $movie = $this->movieRepository->findOneBy(['id' => $id]);

        if (!$movie) {
            return View::create(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $movie
            ->setTitle($data['title'] ?? "")
            ->setDescription($data['description'] ?? "")
            ->setRuntime($data['runtime'] ?? "")
            ->setRealeaseAt(new \DateTime($data['realeaseAt']) ?? "");

        $errors = $validator->validate($movie);
        if (count($errors) > 0) {
            return View::create($errors, Response::HTTP_ACCEPTED);
        }

        $movieUpdated = $this->movieRepository->save($movie);

        return View::create($movieUpdated, Response::HTTP_OK);
    }

    /**
     * Delete a Movie.
     * @Rest\Delete("/movies/{id}", name="delete_movie")
     * 
     * @return View
     */
    public function deleteMovie(int $id): View
    {
        $movie = $this->movieRepository->findOneBy(['id' => $id]);

        if (!$movie) {
            return View::create(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $this->movieRepository->remove($movie);

        return View::create(['status' => 'removed', Response::HTTP_NO_CONTENT]);
    }
}
