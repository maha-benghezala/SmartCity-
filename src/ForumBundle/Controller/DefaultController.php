<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {


        //Ajout commentaire :
        if ($request->request->get('ajoutcmt')){
            $commentaire = new Commentaire();
            $commentaire->setContenu($request->request->get('commentaire'));
            $publication = $this->getDoctrine()->getManager()->getRepository('ForumBundle:Publication')->find($request->request->get('publication'));
            $commentaire->setPublication($publication);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

        }



        //Afficher Publication :
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository('ForumBundle:Publication')->createQueryBuilder('p')
            ->addOrderBy('p.datePublication','DESC')
            ->getQuery()
            ->execute();
        $paginator  = $this->get('knp_paginator');
        $publications = $paginator->paginate(
            $modele, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        //Afficher Commentaire :

        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('ForumBundle:Commentaire')->findAll();

        // ------------- return :

        return $this->render('ForumBundle:Default:index.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
            'modeles' => $publications,
            'commentaire' => $comment,
        ));
    }
}
