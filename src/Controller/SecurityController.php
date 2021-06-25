<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use function PHPUnit\Framework\returnArgument;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, PromoRepository $promoRepository)
    {

        //UserPasswordEncoderInterface pour pouvoir fonctionner attendde l'objet User, que celui-ci hérite de la class UserInterface, cette derniere class attend des methodes bien précise afin d'assurer du bon fonctionnement de l'authentification (cf User Entity)
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $user->setPromo(0);
            $user->setDateInscription(new \DateTime());

            $nom = $request->request->get('registration')['nom'];
            $prenom = $request->request->get('registration')['prenom'];
            $to = $request->request->get('registration')['email'];
            $date= strtotime("now + 10 day");
            $datef=date("d-m-Y", $date);
            $promo=$promoRepository->findByRegistrationName('NouveauClients');// recupere la 1er promo
        $promotion=$promo->getNom();
        $remise=$promo->getRemise();
        $montant=$promo->getMontantmin();

            $transporter = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('dorancocovid2021@gmail.com')
                ->setPassword('Dorancosalle06');

            $mailer = new \Swift_Mailer($transporter);

            $mess = "Bienvnue parmis nous $nom $prenom . Pour vous remercier de votre inscription, utilisez dés à present jusqu'au $datef de la promotion $promotion, d'un montant de $remise € pour un montant d'achat minimum de $montant €";

            $motif = "Cadeau de bienvenue";
            $from = 'dorancocovid2021@gmail.com';

            $message = (new \Swift_Message("$motif"))
                ->setFrom($from)
                ->setTo([$to]);// je veux que tu recupere l'email dans la table user

            $cid = $message->embed(\Swift_Image::fromPath('https://loremflickr.com/g/320/240/paris'));
            $message->setBody(
                $this->renderView('front/mail_template.html.twig', [
                    'message' => $mess,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'motif' => $motif,
                    'email' => $to, // affiche email de l'utilisateur
                    'cid' => $cid
                ]),
                'text/html'
            );
            $mailer->send($message);


            $manager->persist($user);
            $manager->flush();


            $this->addFlash('success', 'Félicitation votre compte a bien été connecté!');

            return $this->redirectToRoute('login');

        endif;
        return $this->render('security/inscription.html.twig', [
            'formu' => $form->createView()

        ]);

    }


    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('security/connexion.html.twig');

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {


    }


}
