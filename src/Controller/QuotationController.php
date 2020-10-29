<?php

namespace App\Controller;

use App\Entity\Quotation;
use App\Form\QuotationType;
use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quotation")
 */
class QuotationController extends AbstractController
{
    /**
     * @Route("/", name="quotation_index", methods={"GET"})
     */
    public function index(QuotationRepository $quotationRepository): Response
    {
        return $this->render('quotation/index.html.twig', [
            'quotations' => $quotationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quotation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quotation);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('quotation/new.html.twig', [
            'quotation' => $quotation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quotation_show", methods={"GET"})
     */
    public function show(Quotation $quotation): Response
    {
        return $this->render('quotation/show.html.twig', [
            'quotation' => $quotation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quotation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quotation $quotation): Response
    {
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quotation_index');
        }

        return $this->render('quotation/edit.html.twig', [
            'quotation' => $quotation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quotation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quotation $quotation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quotation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quotation_index');
    }
}
