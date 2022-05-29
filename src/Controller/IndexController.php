<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/articles", name="app_articles")
     */
    public function articles(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
        -> getRepository(Article::class)
        ->findAll();

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'IndexController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/details/{id}", name="app_details")
     */
    public function details($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = $entityManager
            ->getRepository(Comment::class)
            ->findBy(array('idArticle' => $id));

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $articles = $entityManager
            ->getRepository(Article::class)
            ->find($id);
        
        if ($this->getUser() != null) {

            $comment->setArticle($articles);
            $comment->setAuthor($this->getUser());
            $comment->setDate(new \DateTime());

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($comment);
                $entityManager->flush();

                return $this->redirectToRoute('app_recettes_details', array('id' => $id));
            }
        }

        return $this->render('recettes/recette_details.html.twig', [
            'controller_name' => 'IndexController',
            'article' => $article,
            'form' => $form,
            'commentaire' => $commentaire
        ]);
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
        -> getRepository(Article::class)
        ->findAll();
        
        return $this->render('home/home.html.twig', [
            'controller_name' => 'IndexController',
            'articles' => $articles,
        ]);
    }
}
