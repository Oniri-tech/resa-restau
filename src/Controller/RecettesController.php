<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Plat;
use App\Entity\Resa;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;

class RecettesController extends AbstractController
{
    /**
     * @Route("/", name="recettes")
     */
    public function index( PlatRepository $repo)
    {
        $plats = $repo->findAll();

        return $this->render('recettes/index.html.twig', [
            'controller_name' => 'RecettesController',
            'plats' => $plats
        ]);
    }

    /**
     * @Route("/plat/new", name="plat_add")
     * @Route("/plat/{id}/edit", name ="plat-edit")
     */
    public function form(Plat $plat = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$plat){
           $plat = new Plat(); 
        }

        $form = $this->createFormBuilder($plat)
            ->add('Nom', TextType::class)
            ->add('Description', TextareaType::class)
            ->add('image', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $manager->persist($plat);
            $manager->flush();

            return $this->redirectToRoute('recettes');
        }
        
        return $this->render('recettes/add.html.twig', [
            'formPlat' => $form->createView(),
            'editMode' => $plat->getId() !== null
        ]);
    }
    /**
     * @Route("/reserv", name="reservation")
     */
    public function reservation(Request $request, EntityManagerInterface $manager)
    {
        $resa = new Resa();   
        $form = $this->createFormBuilder($resa)
            ->add('nom', TextType::class)
            ->add('personnes', IntegerType::class)
            ->add('heure', TimeType::class)
            ->add('date', DateType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $manager->persist($resa);
            $manager->flush();

            return $this->redirectToRoute('recettes');
        }
        return $this->render('recettes/res.html.twig',['formRes' => $form->createView()]);
    }
}
