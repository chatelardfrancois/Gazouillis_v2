<?php

namespace App\Controller;

use App\Entity\Gazouillis;
use App\Form\GazouillisType;
use App\Repository\CategoryRepository;
use App\Repository\GazouillisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/home")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function home(GazouillisRepository $repo):Response
    {

        $tabDeGazouillis = $repo->findBy([], ["dateCreated" => "DESC"]);

        //$route = new Route
        return $this->render("front/home.html.twig", ['tabDeGazouillis'=>$tabDeGazouillis]);
    }
    /**
     * @Route("/gazouiller", name="gazouillis_ajouter" )
     */
    public function ajouter(EntityManagerInterface $em,Request $request):Response
    {
        $gazouillis = new Gazouillis(); // je crée une Entity "vide"
        // je créé mon formulaire (type de formulaire + entity)
        $formGazouillis = $this->createForm(GazouillisType::class,$gazouillis);
        // associer le formulaire avec les données envoyées
        // hydrater $personne
        $formGazouillis->handleRequest($request);

        if($formGazouillis->isSubmitted() && $formGazouillis->isValid())
        {
            $user = $this->getUser();
            $gazouillis->setUser($user);
            $gazouillis->setIsPublished(0);
            $gazouillis->setDateCreated(new \DateTime('now'));
            $em->persist($gazouillis);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('front/ajouter.html.twig',
            [ 'formGazouillis' =>$formGazouillis->createView()]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact():Response
    {
        return $this->render("front/contact.html.twig");
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(GazouillisRepository $repo, CategoryRepository $cateRepo):Response
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
        return $this->render("front/search.html.twig", ['tabDeGazouillis'=>$tabDeGazouillis, 'categories'=>$categories]);
    }


}
