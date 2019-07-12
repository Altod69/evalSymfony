<?php

namespace App\Controller;

use App\Entity\BlogSpot;
use App\Form\BlogSpotType;
use App\Repository\BlogSpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/spot")
 */
class BlogSpotController extends AbstractController
{
    /**
     * @Route("/list", name="blog_spot_index", methods={"GET"})
     */
    public function listPostsAction(BlogSpotRepository $blogSpotRepository): Response
    {
        return $this->render('blog_spot/index.html.twig', [
            'blog_spots' => $blogSpotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="blog_spot_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blogSpot = new BlogSpot();
        $form = $this->createForm(BlogSpotType::class, $blogSpot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogSpot);
            $entityManager->flush();

            return $this->redirectToRoute('blog_spot_index');
        }

        return $this->render('blog_spot/new.html.twig', [
            'blog_spot' => $blogSpot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_spot_show", methods={"GET"})
     */
    public function show(BlogSpot $blogSpot): Response
    {
        return $this->render('blog_spot/show.html.twig', [
            'blog_spot' => $blogSpot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_spot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BlogSpot $blogSpot): Response
    {
        $form = $this->createForm(BlogSpotType::class, $blogSpot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_spot_index');
        }

        return $this->render('blog_spot/edit.html.twig', [
            'blog_spot' => $blogSpot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_spot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BlogSpot $blogSpot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogSpot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blogSpot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_spot_index');
    }
}
