<?php

namespace questionnaireBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use questionnaireBundle\Entity\Abonnement;
use questionnaireBundle\Entity\actualite;
use questionnaireBundle\Entity\historique;
use questionnaireBundle\Entity\Probleme;
use questionnaireBundle\Entity\question;
use questionnaireBundle\Entity\Suggestion;
use questionnaireBundle\Form\actualiteType;
use questionnaireBundle\Form\ProblemeType;
use questionnaireBundle\Form\questionType;
use questionnaireBundle\Form\SelectType;
use questionnaireBundle\Form\solutionType;
use questionnaireBundle\Form\SuggestionType;
use questionnaireBundle\questionnaireBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use sondageBundle\Entity\avis;
use sondageBundle\Entity\vote;
use Swift_Attachment;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use testBundle\Entity\User;

class DefaultController extends Controller
{

    public function ajoutproblemeAction(Request $request,UserInterface $username)
    {
        $username = $this->getUser();
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(array('idUser'=>$username));
        if(!$abonnement){
            return $this->redirectToRoute('afficher_municipalite');
        }
        else {
            $probleme = new Probleme();
            $form = $this->createForm(ProblemeType::class, $probleme);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $municipalite = $abonnement->getIdMunicipalite();
                //
                $file = $probleme->getImage();
                $file2 = $probleme->getVideo();
                if ($file != null) {

                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    //path win beh yhotha
                    $path = "../web";
                    $file->move($path, $fileName);
                    $probleme->setImage($fileName);
                }
                if ($file2 != null) {
                    $fileName2 = md5(uniqid()) . '.' . $file2->guessExtension();
                    $path2 = "../web";
                    $file2->move($path2, $fileName2);
                    $probleme->setVideo($fileName2);
                }
                $probleme->setDate(new \DateTime("now"));
                $probleme->setEnabled(false);
                $probleme->setStatut(false);
                //cle etrangere
                $probleme->setIdUser($username);
                $probleme->setIdMunicipalite($municipalite);
                $probleme->setNbsignale(0);
                //pour connecter a la doctrine
                $em = $this->getDoctrine()->getManager();
                // ajouter les donnees a la doctrine

                $em->persist($probleme);
                // ajouter les donnee ala bd
                $em->flush();
                return $this->redirectToRoute('Afficher_Probleme_user');
            }
            // view hedhka yabathelha il formulaire hedheka
            return $this->render('questionnaireBundle:Default:index.html.twig', array('form' => $form->createView()));
        }
    }
    public function ajouterSuggestionAction(Request $request,UserInterface $username,$id){
        $Suggestion = new Suggestion();
        $probleme=$this->getDoctrine()->getRepository(Probleme::class)->find($id);
        $username = $this->container->get('security.token_storage')->getToken()->getUser();
        $form=$this->createForm(SuggestionType::class,$Suggestion);

        $form->Request($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $file=$Suggestion->getImage();
            if($file!= null)
            {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $path="../web";
                $file->move($path ,$fileName);
                $Suggestion->setImage($fileName);
            }

            $file1=$Suggestion->getRapport();
            if($file1!= null)
            {
                $fileName1 = md5(uniqid()) . '.' . $file1->guessExtension();
                $path="../web";
                $file1->move($path ,$fileName1);
                $Suggestion->setRapport($fileName1);
            }
            $Suggestion->setType("suggestion sur une probleme");
            $Suggestion->setProbleme($probleme);
            $Suggestion->setDateDebut(new \DateTime("now"));
            $Suggestion->setIdMunicipalite($username);
            $em=$this->getDoctrine()->getManager();
            $em->persist($Suggestion);

            $em->flush();
            return $this->redirectToRoute('Afficher_suggestion_municipalite');
        }
        return $this->render('questionnaireBundle:Default:ajouterSuggestion.html.twig',array('form'=>$form->createView()));
        }
    public function AfficherProblemeAdminAction()
    {

        $probleme=$this->getDoctrine()->getRepository(Probleme::class)->findAll();
        return $this->render("questionnaireBundle:Default:AfficherProblemeAdmin.html.twig",array("probleme"=>$probleme));
    }
    public function ApprouverProblemeAction($id){
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->find($id);
        $email = $probleme->getIdUser()->getEmail();
        $probleme->setEnabled(true);
        $message = \Swift_Message::newInstance()
            ->setSubject('Probleme approuvée')
            ->setFrom('smartcitytunisie@gmail.com')
            ->setTo($email)
            ->setBody('Bonjour,
            je veux vous informer que votre probleme a été approuvée .
            Merci.
            équipe Smart City'
            )
        ;
        $this->get('mailer')->send($message);


        $em = $this->getDoctrine()->getManager();
        $em->persist($probleme);
        $em->flush();
        return $this->redirectToRoute('Afficher_Probleme_admin');
    }
    public function AfficherProblemeMunicipaliteAction()
    {
        $user = $this->getUser();
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->findBy(array('enabled'=>true,'idMunicipalite'=>$user));
        $number = count($probleme);
        return $this->render("questionnaireBundle:Default:AfficherProblemeMunicipalie.html.twig",array('probleme'=>$probleme,'nombre'=>$number));
    }
    public function afficherProblemeUserAction(Request $request)
    {
        $username = $this->getUser();

        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->findAll();
        return $this->render("questionnaireBundle:Default:AfficherProblemeUser.html.twig", array('probleme' => $probleme));

    }
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */

    public function showProblemeAction(UserInterface $username)
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl("Afficher_Probleme_admin"));
        }

        if ($authChecker->isGranted('ROLE_MUNICIPALITE')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("Afficher_Probleme_municipalite"));
        }
        if ($authChecker->isGranted('ROLE_SIMPLE_USER')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("Afficher_Probleme_user"));
        }
    }
    public function abonnerAction($id){
        $user =$this->getUser();
        $municipalite = $this->getDoctrine()->getRepository(User::class)->find($id);
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findBy(array('idMunicipalite'=>$municipalite,'idUser'=>$user));
        if(!$abonnement)
        {

            $abonn = new Abonnement();
            $abonn->setIdMunicipalite($municipalite);
            $abonn->setIdUser($user);
            $abonne = $municipalite->getAbonnements();
            $municipalite->setAbonnements($abonne+1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($municipalite);
            $em->persist($abonn);
            $em->flush();
            return $this->redirectToRoute("Ajouter_Probleme");
        }
        else{
            return $this->redirectToRoute('404');
        }
    }
    public function showSuggestionUserAction(UserInterface $username){
        $username = $this->container->get('security.token_storage')->getToken()->getUser();
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findOneByidUser($username);
        if (!$abonnement){
            return $this->redirectToRoute('afficher_municipalite');
        }
        else{
            $question=$this->getDoctrine()->getRepository(question::class)->findAll();
            $municipalite = $abonnement->getIdMunicipalite();
            $suggestion = $this->getDoctrine()->getRepository(Suggestion::class)->findByidMunicipalite($municipalite);
            $number = count($suggestion);
            return $this->render('questionnaireBundle:Default:affichersuggestionUser.html.twig',array('suggestion'=>$suggestion,'question'=>$question,'num'=>$number));
        }
    }
    public function afficherMunicipaliteAction()
    {
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        $municipalite = $this->getDoctrine()->getRepository(User::class)->findAll();
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->findBy(array('statut' => true));
        $solution = $this->getDoctrine()->getRepository(Suggestion::class)->findAll();
        $question = $this->getDoctrine()->getRepository(question::class)->findAll();
        return $this->render('questionnaireBundle:Default:AfficherMunicipalite.html.twig', array('municipalite' => $municipalite, 'abonnement' => $abonnement, 'probleme' => $probleme, 'solution' => $solution, 'question' => $question));
    }


    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showSuggesstionAction(UserInterface $username)
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl("consultersuggestion_suggestion"));
        }

        if ($authChecker->isGranted('ROLE_MUNICIPALITE')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("Afficher_suggestion_municipalite"));
        }
        if ($authChecker->isGranted('ROLE_SIMPLE_USER')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("afficher_Suggestion_User"));
        }
    }
    public function afficherProblemeSingleAction($id)
    {
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->find($id);
        return $this->render('questionnaireBundle:Default:afficherproblemeseule.html.twig',array('probleme'=>$probleme));
    }
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showMunicipaliteAction(UserInterface $username)
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl("ajouter_municipalite"));
        }

        if ($authChecker->isGranted('ROLE_MUNICIPALITE')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("afficher_municipalite"));
        }
        if ($authChecker->isGranted('ROLE_SIMPLE_USER')) {
            $username = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirect($this->generateUrl("afficher_municipalite"));
        }
    }
    public function deleteAction($id)
    {
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->find($id);
             //recuperer la suggestion selon le problem
        $suggestion= $this->getDoctrine()->getRepository(Suggestion::class)->findBy(array('Probleme'=>$probleme));
        $historique= $this->getDoctrine()->getRepository(historique::class)->findBy(array('Probleme'=>$probleme));
        $em= $this->getDoctrine()->getManager();//connecter à doctrine////
        foreach($suggestion as $x){
            $vote= $this->getDoctrine()->getRepository(vote::class)->findBy(array('suggestion'=>$x));

            foreach($vote as $a){
                $em->remove($a);
            }
            $em->remove($x);
        }
        foreach($historique as $y){

            $em->remove($y);
        }

        $em->remove($probleme);
        $em->flush();
        return $this->redirectToRoute('Afficher_Probleme_admin');
    }
    public function deleteSuggestionAction($id)
    {
        $question = $this->getDoctrine()->getRepository(question::class)->find($id);


        $em= $this->getDoctrine()->getManager();//connecter à doctrine////

            $vote= $this->getDoctrine()->getRepository(avis::class)->findBy(array('idQuestion'=>$question));

            foreach($vote as $a){
                $em->remove($a);
            }
            $em->remove($question);



        $em->flush();
        return $this->redirectToRoute('Afficher_question_municipalite');
        return $this->redirectToRoute('Afficher_question_municipalite');
    }
    public function deleteActualiteMunicipaliteAction($id)
    {
        $actualite = $this->getDoctrine()->getRepository(actualite::class)->find($id);


        $em= $this->getDoctrine()->getManager();//connecter à doctrine////

        $em->remove($actualite);

        $em->flush();
        return $this->redirectToRoute('actualite_municipalite');
    }
    public function deletedashadminAction($id)
    {
        $question= $this->getDoctrine()->getRepository(question::class)->find($id);
        $em= $this->getDoctrine()->getManager();//connecter à doctrine////
        $vote= $this->getDoctrine()->getRepository(avis::class)->findBy(array('idQuestion'=>$question));

        foreach($vote as $a){
            $em->remove($a);
        }
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('DAshboard_Admin');
    }
    public function voirAction($id){
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->findById($id);
        return $this->render('questionnaireBundle:Default:voir.html.twig',array('Probleme'=>$probleme));
    }
    public function consultersuggestionAction()
    {
        $x = $this->getDoctrine()->getRepository(Suggestion::class)->findAll();
        return $this->render('questionnaireBundle:Default:consultersuggestion.html.twig',array('Suggestion'=>$x));
    }
    public function ajouterHistoriqueAction($id)
    {

        $user = $this->getUser();
        $historique = new historique();
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->find($id);
        $date = $probleme->getDate();
        $historique->setDescription("Probléme résolue");
        $historique->setDateDebut($date);
        $historique->setDateFin(new \DateTime("now"));
        $historique->setIdMunicipalite($user);
        $historique->setProbleme($probleme);
        $probleme->setStatut(true);
        $em= $this->getDoctrine()->getManager();
        $em->persist($historique);
        $em->persist($probleme);
        $em->flush();
        return  $this->redirectToRoute('Afficher_Probleme_municipalite');
    }
    public  function  statutProblemeAction()
    {
        $statut = $this->getDoctrine()->getRepository(Probleme::class)->findByStatut(true);
        return $this->render('questionnaireBundle:Default:statuthtml.twig',array('Probleme'=>$statut));
    }
    public function voirHistoriqueAction(Request $request)
    {
        $historique = $this->getDoctrine()->getRepository(historique::class)->findAll();
        $form = $this->createForm(SelectType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $des = $request->get('Desc');
            $asc = $request->get('ASC');
            $muinicipalite = $this->getDoctrine()->getRepository(User::class)->findOneById($request->get('municipalite'));
            if(!$asc){
                if(!$des){
                    $historique = $this->getDoctrine()->getRepository(historique::class)->findBy(array('idMunicipalite'=>$muinicipalite));
                }
                else{
                    $historique = $this->getDoctrine()->getRepository(historique::class)->findBy(array('idMunicipalite'=>$muinicipalite),array('dateFin'=>'DESC'));
                }
            }
            else{
                $historique = $this->getDoctrine()->getRepository(historique::class)->findBy(array('idMunicipalite'=>$muinicipalite),array('dateFin'=>'ASC'));

            }

        }
        return $this->render('questionnaireBundle:Default:historique.html.twig',array('Probleme'=>$historique,'form'=>$form->createView()));
    }
    public function RapportAction($id)
    {
        $probleme = $this->getDoctrine()->getRepository(Suggestion::class)->find($id);
        $rapport = $probleme->getRapport();
        return $this->render('questionnaireBundle:Default:Rapport.html.twig',array('rapport'=>$rapport));
    }
    public function AjouterSolutionAction(Request $request , $id)
    {
        $solution =new Suggestion();
        $probleme =$this->getDoctrine()->getRepository(Probleme::class)->find($id);
        $form=$this->createForm(solutionType::class,$solution);
        $user =$this->getUser();
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $file=$solution->getImage();
            $file1=$solution->getRapport();
            if ($file != null) {

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                //path win beh yhotha
                $path = "../web";
                $file->move($path, $fileName);
                $solution->setImage($fileName);
            }
            if($file1 != null)
            {
                $fileName1 = md5(uniqid()) . '.' . $file1->guessExtension();
                //path win beh yhotha
                $path = "../web";
                $file1->move($path, $fileName1);
                $solution->setRapport($fileName1);
            }
            $solution->setDateDebut(new \DateTime("now"));
            $solution->setIdMunicipalite($user);
            $solution->setProbleme($probleme);
            $solution->setType("Solution");
            $em=$this->getDoctrine()->getManager();
            // ajouter les donnees a la doctrine

            $em->persist($solution);
            // ajouter les donnee ala bd
            $em->flush();
            return $this->redirectToRoute('Afficher_suggestion_municipalite');
        }
        return $this->render('questionnaireBundle:Default:ajouterSolution.html.twig',array('form'=>$form->createView()));

    }
    public function ajouterQuestionnaireAction(Request $request)
    {
        $ajout=new question();
        $user=$this->getUser();
        $form= $this->createForm(questionType::class,$ajout);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $ajout->setDate(new \DateTime("now"));
            $ajout->setIdMunicipalite($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($ajout);
            $em->flush();
            return $this->redirectToRoute('Afficher_question_municipalite');
        }
        return $this->render('questionnaireBundle:Default:Question.html.twig',array('form'=>$form->createView()));
    }
    public function afficherQuestionnaireAction()
    {
      $question=$this->getDoctrine()->getRepository(question::class)->findAll();
      return $this->render('questionnaireBundle:Default:afficherquestion.html.twig',array('question'=>$question));
    }
    public function afficherSuggestionMunicipaliteAction()
    {
        $user=$this->getUser();
        $suggestion=$this->getDoctrine()->getRepository(Suggestion::class)->findBy(array('idMunicipalite'=>$user));
        return $this->render('questionnaireBundle:Default:affichagesuggestionmunicipalite.html.twig',array('sg'=>$suggestion));
    }
    public function questionAction($id,$userid)
    {
        $question=$this->getDoctrine()->getRepository(question::class)->findById($id);
        return $this->render('questionnaireBundle:Default:questioque.html.twig',array('qq'=>$question,'userid'=>$userid));
    }
    public function ajouterAvisAction(Request $request,$id,$userid)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($userid);
        $q=$this->getDoctrine()->getRepository(question::class)->find($id);
        $a=$this->getDoctrine()->getRepository(avis::class)->findBy(array('idUser'=>$user,'idQuestion'=>$q));
        if (!$a){
            $avis =new avis();
            $avis->setIdUser($user);
            $avis->setDate(new \DateTime("now"));
            $avis->setIdQuestion($q);
            $avis->setChoix($request->get('choix'));
            $em= $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            return new Response("Success");
        }
        else{
            return new Response("echec");
        }
    }
    public function afficherAvisAction($id)
    {
        $q=$this->getDoctrine()->getRepository(question::class)->find($id);
        $choix1=$q->getChoix1();
        $choix2=$q->getChoix2();
        $choix3=$q->getChoix3();
        $choix4=$q->getChoix4();
        $avisc1=$this->getDoctrine()->getRepository(avis::class)->findBy(array('choix'=>$choix1,"idQuestion"=>$q));
        $avisc2=$this->getDoctrine()->getRepository(avis::class)->findBy(array('choix'=>$choix2,"idQuestion"=>$q));
        $avisc3=$this->getDoctrine()->getRepository(avis::class)->findBy(array('choix'=>$choix3,"idQuestion"=>$q));
        $avisc4=$this->getDoctrine()->getRepository(avis::class)->findBy(array('choix'=>$choix4,"idQuestion"=>$q));
        $nc1 = count($avisc1);
        $nc2 = count($avisc2);
        $nc3 = count($avisc3);
        $nc4 = count($avisc4);
        //bundle hadher
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Avis', 'Nombre'],
                [$choix1,     $nc1],
                [$choix2,     $nc2],
                [$choix3,     $nc3],
                [$choix4,     $nc4]

            ]
        );
        $pieChart->getOptions()->setTitle('Résultat des avis');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('questionnaireBundle:Default:afficheavis.html.twig', array('piechart' => $pieChart));

    }
    public function dashboardAdminAction()
    {
        $probleme=$this->getDoctrine()->getRepository(Probleme::class)->findAll();
        $suggestion=$this->getDoctrine()->getRepository(Suggestion::class)->findAll();
        $question=$this->getDoctrine()->getRepository(question::class)->findAll();
        $user=$this->getDoctrine()->getRepository(User::class)->findAll();
        $nprobleme = count($probleme);
        $nsuggestion = count($suggestion);
        $nquestion = count($question);
        $nuser = count($user);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Satestique', 'Globale'],
                ['Problemes',     $nprobleme],
                ['Solutions',      $nsuggestion],
                ['Suggestions',  $nquestion],
                ['Utilisateurs', $nuser]
            ]
        );
        $pieChart->getOptions()->setTitle('Satestiques Globale');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

      return $this->render('questionnaireBundle:Default:dashboardadmin.html.twig',array('d'=>$user,'q'=>$question,'p'=>$probleme,'s'=>$suggestion,'piechart' => $pieChart));
    }
    public function ajouterActualiteAction(Request $request)
    {
       $actualite=new actualite();
        $user=$this->getUser();
        $form= $this->createForm(actualiteType::class,$actualite);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $actualite->setIdMunicipalite($user);
            $actualite->setDate(new \DateTime("now"));
            $em=$this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();
            return $this->redirectToRoute('actualite_municipalite');

        }
        return $this->render("questionnaireBundle:Default:ajouteractualite.html.twig",array('form'=>$form->createView()));
    }
    public function AfficherToutActualiteAction()
    {
        $user=$this->getUser();
        $abonne=$this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(array('idUser'=>$user));
        if (!$abonne)
        {
            return $this->redirectToRoute('404');
        }
        else{
            $municipalite= $abonne->getIdMunicipalite();
            $actualite=$this->getDoctrine()->getRepository(actualite::class)->findBy(array('idMunicipalite'=>$municipalite));
            return $this->render("questionnaireBundle:Default:afficherActualite.html.twig",array('act'=>$actualite));
        }
    }
    public function SuggestionMunicipaliteAction()
    {
        $question = $this->getDoctrine()->getRepository(question::class)->findBy(array('idMunicipalite'=>$this->getUser()));
        return $this->render('questionnaireBundle:Default:AfficherQuestionMunicipalite.html.twig',array('question'=>$question));
    }
    public function errorAction()
    {
        /**$message = Swift_Message::newInstance()
            ->setFrom('monguide07@gmail.com')
            ->setTo('jasser.hadhri@esprit.tn')
            ->setSubject('Subject')
            ->setBody('Body')

        ;
        $attachment = \Swift_Attachment::fromPath('C:/Users/Jasser/Desktop/cv jasser hadhri.pdf');
        $message->attach($attachment);

        $this->get('mailer')->send($message);**/
        return $this->redirectToRoute('afficher_question_admin');
    }
    public function afficherQuestionAdminAction()
    {
        $question = $this->getDoctrine()->getRepository(question::class)->findAll();
        return $this->render('questionnaireBundle:Default:afficherQuestionAdmin.html.twig',array('question'=>$question));
    }
    public function searchAction(Request $request)
    {
        $form = $this->createForm(SelectType::class);
        $date = $request->get('date');
        $id = $request->get('municipalite');
        if(!$id){
                $historique = $this->getDoctrine()->getRepository(historique::class)->findBy(array('dateFin' => $date));
        }
        else{
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
            $historique = $this->getDoctrine()->getRepository(historique::class)->findBy(array('idMunicipalite'=>$user),array('dateFin'=>$date));
            if(!$historique){
                return new Response("vide");
            }
            else{
                return $this->render('questionnaireBundle:Default:historique.html.twig',array('Probleme'=>$historique,'form'=>$form->createView()));
            }
        }
    }
    public function dashboardMunAction()
    {
        $municipalite = $this->getUser();
        $probleme=$this->getDoctrine()->getRepository(Probleme::class)->findBy(array('idMunicipalite'=>$municipalite));
        $suggestion=$this->getDoctrine()->getRepository(Suggestion::class)->findBy(array('idMunicipalite'=>$municipalite));
        $question=$this->getDoctrine()->getRepository(question::class)->findBy(array('idMunicipalite'=>$municipalite));
        $nprobleme = count($probleme);
        $nsuggestion = count($suggestion);
        $nquestion = count($question);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Satestique', 'Globale'],
                ['Problemes',     $nprobleme],
                ['Solutions',      $nsuggestion],
                ['Suggestions',  $nquestion],
            ]
        );
        $pieChart->getOptions()->setTitle('Satestiques Globale');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('questionnaireBundle:Default:dashboardmunicipalite.html.twig',array('q'=>$question,'p'=>$probleme,'s'=>$suggestion,'piechart' => $pieChart));
    }
    public function AfficherToutActualiteMunicipaliteAction()
    {
        $user=$this->getUser();

            $actualite=$this->getDoctrine()->getRepository(actualite::class)->findBy(array('idMunicipalite'=>$user));
            return $this->render("questionnaireBundle:Default:afficherActualite.html.twig",array('act'=>$actualite));

    }
    public function pageMunicipaliteAction($id)
    {
        $user=$this->getUser();
        $page=$this->getDoctrine()->getRepository(actualite::class)->findBy(array('idMunicipalite'=>$user));
        return $this->render("questionnaireBundle:Default:pagemuni.html.twig",array('pg'=>$page));

    }
    public function bannirProblemeAction($id)
    {
        $probleme = $this->getDoctrine()->getRepository(Probleme::class)->find($id);
        $probleme->setEnabled(0);
        $em=$this->getDoctrine()->getManager();
        $em->persist($probleme);
        $em->flush();
        return $this->redirectToRoute('DAshboard_Admin');
    }
    public function deleteSolutionAction($id){
        $em = $this->getDoctrine()->getManager();
        $solution = $this->getDoctrine()->getRepository(Suggestion::class)->find($id);
        $vote = $this->getDoctrine()->getRepository(vote::class)->findBy(array('suggestion'=>$solution));
        foreach ($vote as $x)
        {
            $em->remove($x);

        }
        $em->remove($solution);
        $em->flush();
        return $this->redirectToRoute('DAshboard_Admin');
    }
    public function bannirUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setEnabled(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('DAshboard_Admin');
    }
    public function approuverUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setEnabled(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('DAshboard_Admin');
    }
}
