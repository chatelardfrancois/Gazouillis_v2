<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Gazouillis;
use App\Form\CategoryType;
use App\Form\GazouillisType;
use App\Repository\CategoryRepository;
use App\Repository\GazouillisRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */
class BackController extends AbstractController
{


    /**
     * @Route("/categorie/gerer", name="back_categorie_gerer" )
     */
    public function ajouterCate(EntityManagerInterface $em,Request $request, CategoryRepository $cateRepo):Response
    {
        $category = new Category(); // je crée une Entity "vide"
        // je créé mon formulaire (type de formulaire + entity)
        $formCate = $this->createForm(CategoryType::class,$category);
        // associer le formulaire avec les données envoyées
        // hydrater $personne
        $formCate->handleRequest($request);
        $categories = $cateRepo->findBy([],["id" => "DESC"]);

        if($formCate->isSubmitted() && $formCate->isValid())
        {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('back_categorie_gerer');
        }
        return $this->render('back/gerer.category.html.twig',
            [ 'formCate' =>$formCate->createView(), 'categories'=>$categories]);
    }
    /**
     * @Route("/categorie/enlever/{id}", name="back_categorie_enlever" )
     */
    public function enleverCate($id,EntityManagerInterface $em, CategoryRepository $repo):Response
    {
        if($id!=-1){
            $category = $repo ->find($id);
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('back_categorie_gerer');
    }

    /**
     * @Route("/modifier/{id}", name="back_gazouillis_modifier" )
     */
    public function modifier(Gazouillis $gazouillis, EntityManagerInterface $em, Request $request):Response
    {

        // je créé mon formulaire (type de formulaire + entity)
        $formGazouillis = $this->createForm(GazouillisType::class,$gazouillis);
        // associer le formulaire avec les données envoyées
        // hydrater $personne
        $formGazouillis->handleRequest($request);

        if($formGazouillis->isSubmitted() && $formGazouillis->isValid())
        {
            $gazouillis->setIsPublished(0);
            $em->flush();
            return $this->redirectToRoute('back_home');
        }
        return $this->render('back/modifier.html.twig',
            [ 'formGazouillis' =>$formGazouillis->createView()]);
    }

    /**
     * @Route("/enlever/{id}", name="back_gazouillis_enlever" )
     */
    public function enlever(Gazouillis $gazouillis, EntityManagerInterface $em):Response
    {

        // pas de beoin de persister
        $em->remove($gazouillis);
        $em->flush();
        return $this->redirectToRoute('back_home');
    }
    /**
     * @Route("/", name="back_home" )
     */
    public function liste(GazouillisRepository $repo, CategoryRepository $cateRepo):Response
    {
        if($_GET!=null) {
            if ($_GET['searchBy'] != "") {
                $test = $_GET['searchBy'];
                $tabDeGazouillis = $repo->findBy(["category" => "$test"], ["dateCreated" => "DESC"]);
            } else{
                $tabDeGazouillis = $repo->findBy([], ["dateCreated" => "DESC"]);
            }
        } else {
            $tabDeGazouillis = $repo->findBy([], ["dateCreated" => "DESC"]);
        }

        $categories = $cateRepo->findBy([],["id" => "DESC"]);
        return $this->render("back/home.html.twig",['tabDeGazouillis'=>$tabDeGazouillis, 'categories'=>$categories]);
    }

}
