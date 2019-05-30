<?php

namespace sondageBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use questionnaireBundle\Entity\Suggestion;
use Symfony\Component\HttpFoundation\Request;
use sondageBundle\Entity\vote;
use sondageBundle\Form\voteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller
{
    public function sondageAction($id,Request $request,UserInterface $username)
    {
        $sondage= new vote();
        $suggestion = $this->getDoctrine()->getRepository(Suggestion::class)->find($id);
        $username = $this->container->get('security.token_storage')->getToken()->getUser();

            //pour connecter a la doctrine
            $em=$this->getDoctrine()->getManager();
            // ajouter les donnees a la doctrine
            $sondage->setSuggestion($suggestion);
            $vot = $request->get("vote");
            if ($vot == "Oui" ){
                $sondage->setVote(true);
            }
            else{
                $sondage->setVote(false);}
            /**$vote= $this->getDoctrine()->getRepository(Vote::class)->findByVote(1);
            $nombre = count($vote);
            $vote1= $this->getDoctrine()->getRepository(Vote::class)->findAll();
            $nombre2 = count($vote1);
            $pourcentage = $nombre/$nombre2 ;**/
            $user = $this->getDoctrine()->getRepository(vote::class)->findVote($id,$username);
            if (!$user) {
                $sondage->setIdUser($username);
                $sondage->setSuggerer($request->get("suggestion"));
                $em->persist($sondage);
                // ajouter les donnee ala bd
                $em->flush();
                return new Response('Success');
            }
            else{
                return new Response("Tu as déja voté");
            }
    }
    public function getVoteAction($id)
    {
        $votey=$this->getDoctrine()->getRepository(vote::class)->findBy(array('suggestion'=>$id,'vote'=>true));
        $voten=$this->getDoctrine()->getRepository(vote::class)->findBy(array('suggestion'=>$id,'vote'=>false));
        $yes = count($votey);
        $no = count($voten);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Vote', 'Nombre'],
                ['Oui',     $yes],
                ['Non',      $no]
            ]
        );
        $pieChart->getOptions()->setTitle('Résultat du sondage');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('sondageBundle:Default:resultats.html.twig', array('piechart' => $pieChart));
    }

}
