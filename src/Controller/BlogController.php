<?php

namespace App\Controller;

use App\Entity\Artic;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    // une route est définie par 2 arguments : son chemin (/blog) dans l'url et son nom (app_blog)
    public function index(ArticRepository $repo): Response
    {
        // repos est instance de la classe ArticRepository et possède du cout les 4 méthodes de bases find(), findOneBy()
        // , findAll(), findBy()
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            "articles" => $articles
        ]);
        // *render() permet d'afficher le contenue d'un template. Elle va chercher directement dans le dossier template.
    }
    // 3 ligne de code (route+function+ce que l'on veut)
    #[Route('/', name:'home')]
    public function home() :Response
    {
        return $this->render('blog/home.html.twig',[
            'title' => 'Bienvenu sur mon blog',
            'age' => 28,
        ]);
        // dans le render en deuxième argument on peu envoyer des données dans la vue (twig) sous forme de tableau avec indice => valeur
        // l'indice étant le nom de la variable dans le fichier twig et valeur sa valeur réel
    }

    #[Route('/blog/modifier/{id}',name:"blog_modifier")]

    #[Route('/blog/ajout',name:"blog_ajout")]

    public function form(Request $globals, EntityManagerInterface $manager, Artic $artic = null) : Response
    {
        if($artic == null)
        
        $artic = new Artic;
        $form = $this->createForm(ArticleType::class, $artic);
        $form->handleRequest($globals);
        // HandleRequest permet de récupérer les éléments tout les données de mes inputs
        
        if($form->isSubmitted() && $form->isValid())
        {
            // dd($globals->request);
            // $artic->setTitle('un titre');
            // dd($artic);
            $artic->setCreatedAt(new \Datetime);
            // dd($artic);
            // persist() va permettre de preparer ma requette sql a envoyer par rapport à l'objet donné en argument
            $manager->persist($artic);
            // *flush() permettre d'executer tout les persist précédent
            $manager->flush();
            // redirectToRoute() permet de rediriger vers une autre page de notre site à l'aide du nom de la route(home)
            return $this->redirectToRoute('home');
        }
        return $this->render('blog/form.html.twig',[
        'form' => $form,
        'editMode' => $artic->getId() !== null
    ]);
    }
    #[Route('blog/gestion', name:'blog_gestion')]
    public function gestion(ArticRepository $repo) : Response
    {
        $articles = $repo->findAll();
        return $this->render('blog/gestion.html.twig' , [
            'articles' => $articles,
        ]);
    }
    #[Route('/blog/show/{id}', name:"blog_show")]
    public function show($id,ArticRepository $repo)
    {
        $artic =$repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $artic,
        ]);
    }
    /**
     * !pour récupérer un article par son id on a 2 méthodes
     * *la première :
     *      *on a besoin de l'id en paramètre de la route 
     *         ! #[Route('/chemin/{id}', name:'nomRoute')]
     *      *on récupère la valeur de l'id dans la méthode et on récupère le Repository nécessaire
     *          ! public function nomFonction($id,   MonRepository $repo)
     *  *derrrière on peut utiliser la méthode find() de mon repo pour récupérer un élément avec son id
     *          ! $uneVariable = $repo->find($id);
     * *la deuxième :
     *      *on a besoin de l'id en paramètre de la Route
     *      ! #[Route('/chemin/{id}', name:'nomRoute')]
     *      * on va déclarer dans la méthode en paramètre l'entity que l'on veut récupérer
     *      ! public function nomFonction(MonEntity $monEntity)
     * 
     */  
    #[Route('/blog/supprimer/{id}', name: 'blog_supprimer')]
    public function supprimer (Artic $artic, EntityManagerInterface $manager)
    {
        $manager->remove($artic);
        $manager->flush();
        return $this->redirectToRoute('blog_gestion');

    }
    // #[Route('/blog/ajout',name:"blog_ajout")]

}
