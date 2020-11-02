<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $encoder;
    private $crudUrlGenerator;

    public function __construct(UserPasswordEncoderInterface $encoder, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->encoder = $encoder;
    }

//    /**
//     * @Route("/password/change", name="change_password", methods={"GET","POST"})
//     */
//    public function change_password(Request $request)
//    {
//        $user = $this->getUser();
////        $quotation = new Quotation();
////        $form = $this->createForm(User::class, $quotation);
////        $form->handleRequest($request);
//
////        if ($form->isSubmitted() && $form->isValid()) {
//        if ($request->isMethod('POST')) {
//            $this->getDoctrine()->getRepository(User::class)->upgradePassword($user, $this->encoder->encodePassword($user, 'admin'));
//            return $this->redirectToRoute('app_logout');
//        }
//
//        $url = $this->crudUrlGenerator
//            ->build()
//            ->setDashboard(DashboardController::class)
//            ;
//
//        return $this->render('user/_change_password_form.html.twig', ["url" => $url]);
//    }

//    /**
//     * @Route("/password/change/v1", name="change_password", methods={"GET","POST"})
//     */
//    public function change_password(Request $request)
//    {
//        $user = $this->getUser();
//        $form = $this->createFormBuilder($user)->add('Current Password')->getForm();
//        $form->handleRequest($request);
//
////        if ($form->isSubmitted() && $form->isValid()) {
//        if ($request->isMethod('POST')) {
//            $this->getDoctrine()->getRepository(User::class)->upgradePassword($user, $this->encoder->encodePassword($user, 'admin'));
//            return $this->redirectToRoute('app_logout');
//        }
//
//        return $this->render('@EasyAdmin/crud/new.html.twig', ["new_form" => $form]);
//    }


}
