<?php

namespace testBundle\Controller;

use questionnaireBundle\Entity\actualite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use testBundle\Entity\User;
use testBundle\Form\MunicipaliteType;
use testBundle\Form\UserType;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $actualite = $this->getDoctrine()->getRepository(actualite::class)->findAll();
        return $this->render('testBundle:Default:index.html.twig',array('actualite'=>$actualite));
    }
    public function inscriptionAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $file=$user->getImage();
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            if($file != null)
            {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $path="../web";
                $file->move($path ,$fileName);
                $user->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $user->setPassword($password);
            $user->setEnabled(1);
            $user->addRole("ROLE_SIMPLE_USER");
            $em->persist($user);

            $em->flush();
            return $this->redirectToRoute('fos_user_security_login');

        }
        return $this->render('testBundle:Default:inscription.html.twig',array('form'=>$form->createView()));
        }
    public function ajouterMunicipaliteAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(MunicipaliteType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file=$user->getImage();

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            if($file!= null)
            {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $path="../web";
                $file->move($path ,$fileName);
                $user->setImage($fileName);
            }
            //pour connecter a la doctrine
            $em = $this->getDoctrine()->getManager();
            // ajouter les donnees a la doctrine
            $user->setPassword($password);
            $user->setEnabled(1);
            $user->setAbonnements(0);
            $user->addRole("ROLE_MUNICIPALITE");
            $em->persist($user);
            // ajouter les donnee ala bd
            $em->flush();
            return $this->redirectToRoute('Affiche_Municipalite');
             }
        return $this->render('testBundle:Default:ajouterMunicipalite.html.twig',array('form'=>$form->createView()));
    }
    public function showMunicipaliteAction()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('testBundle:Default:showMunicipalite.html.twig',array('user'=>$user));
    }
    public function editMunicipaliteAction(Request $request,$id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createForm(MunicipaliteType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $user->getImage();
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            if ($file != null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $path = "../web";
                $file->move($path, $fileName);
                $user->setImage($fileName);
            }
            //pour connecter a la doctrine
            $em = $this->getDoctrine()->getManager();
            // ajouter les donnees a la doctrine
            $user->setPassword($password);
            $em->persist($user);
            // ajouter les donnee ala bd
            $em->flush();
            return $this->redirectToRoute('Affiche_Municipalite');
        }
        return $this->render('testBundle:Default:ajouterMunicipalite.html.twig',array('form'=>$form->createView()));

    }
    public function afficherMunicipaliteAdminAction()
    {
        $municipalite=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('testBundle:Default:afficheMunicipalite.html.twig',array('tab'=>$municipalite));

    }
    public function homeAction()
    {
       return $this->render('testBundle:Default:maha.html.twig');
    }

}
