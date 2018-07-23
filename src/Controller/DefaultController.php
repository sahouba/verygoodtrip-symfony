<?php

namespace App\Controller;
use App\Entity\Trip;
use App\Entity\Country;
use App\Form\SerachType;

use App\Repository\TripRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
      // $trip = new Trip();
      // $formSearch = $this->createForm(SerachType::class, $trip);
      // $formSearch->handleRequest($request);
      //   return $this->render('default/index.html.twig', array('formSearch' => $formSearch->createView()));
      $countryRepo =$this->getDoctrine()->getRepository(country::class);
      $tripRepo =$this->getDoctrine()->getRepository(Trip::class);
    //  $countries=$countryRepo->findAll();
    //->findAll()renvoie les pays ordonnés par id
    //-> findBy() permet de filter (agr1), de trier(arg2) et de limiter 
      $countries  =$countryRepo->findBy([],['name'=>'ASC']);
      $trips=null;
      if ($request->isMethod('post')) {
        //formulaire posté
        // récupération des données postées
        $country_id=intval($request->get('country'));
        $date_start=$request->get('date_start');
        $date_end  =$request->get('date_end');
        $price     =floatval($request->get('price'));
        $dates     =['start'=>$date_start,'end'=>$date_end];

        //echo $country_id;
       //obtention des voyages en fonction des critéres sélectionnés
       $trips =$tripRepo->findByCriteria($country_id,$dates,$price);

      }
      return $this->render('default/index.html.twig',array('countries' =>$countries,'trips'=>$trips));

    }
    /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(TripRepository $tripRepository): Response
    {
            return $this->render('default/recherche.html.twig', ['trip' => $tripRepository->findAll()]);
             //return $this->render('default/recherche.html.twig', ['trip' => $trip]);

    }


    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('default/dashboard.html.twig');
    }
}
