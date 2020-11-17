<?php


namespace App\Controller;


use App\Entity\Building;
use App\Entity\Citizen;
use App\Entity\Quotation;
use App\Entity\User;
use App\Form\QuotationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingpageController extends AbstractController
{


    /**
     * @Route("/", name="homepage")
     */
    public function homepage(): Response {
        $buildings = $this->getDoctrine()->getRepository(Building::class)->countBuildings();
        $employee = $this->getDoctrine()->getRepository(User::class)->countEmployee();
        $quote = $this->getDoctrine()->getRepository(Quotation::class)->countQuote();
        $citizen = $this->getDoctrine()->getRepository(Citizen::class)->countCitizen();
        $form = $this->createForm(QuotationType::class);
        return $this->render('LandingPage/index.html.twig', ["numberOfCitizen" => $citizen, "numberOfQuote" => $quote, "numberOfBuildings" => $buildings, "numberOfEmployee" => $employee, "quoteForm" => $form->createView()]);
    }

    /**
     * @Route("about", name="about")
     */
    public function about(): Response {
        $buildings = $this->getDoctrine()->getRepository(Building::class)->findAll();
        $form = $this->createForm(QuotationType::class);
        return $this->render('LandingPAge/about.html.twig', ["buildings" => $buildings, "quoteForm" => $form->createView()]);
    }

    /**
     * @Route("contact", name="contact")
     */
    public function contact(): Response {
        return $this->render("LandingPage/contact.html.twig");
    }

    /**
     * @Route("services", name="service")
     */
    public function service(): Response {
        return $this->render("LandingPage/services.html.twig");
    }

    /**
     * @Route("projects", name="project")
     */
    public function project(): Response {
        return $this->render("LandingPage/projects.html.twig");
    }

    /**
     * @Route("blog", name="blog")
     */
    public function blog(): Response {
        return $this->render("LandingPage/blog-home.html.twig");
    }

    /**
     * @Route("elements", name="elements")
     */
    public function element(): Response {
        return $this->render("LandingPage/elements.html.twig");
    }
}