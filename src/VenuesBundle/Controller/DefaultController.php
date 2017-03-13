<?php

namespace VenuesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use VenuesBundle\Entity\EmailQueue;
use VenuesBundle\Entity\Venues;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $venues = $this->getDoctrine()->getRepository('VenuesBundle:Venues')->findAll();

        return $this->render('VenuesBundle:Default:index.html.twig', ['venues' => $venues]);
    }

    /**
     * @Route("/create", name="create_venue")
     */
    public function createAction(Request $request)
    {
        $venue = new Venues;

        $form = $this->createFormBuilder($venue)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('venue_type', ChoiceType::class, array('choices' => ['Office' => 'Office', 'Hotel' => 'Hotel'], 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextAreaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('address', TextAreaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('venue_manager', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('capacity', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Venue', 'attr' => array('class' => 'btn btn-info', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $venue_type = $form['venue_type']->getData();
            $description = $form['description']->getData();
            $address = $form['address']->getData();
            $venue_manager = $form['venue_manager']->getData();
            $email = $form['email']->getData();
            $capacity = $form['capacity']->getData();
            $created_date = new \DateTime('now');

            $venue->setName($name);
            $venue->setVenueType($venue_type);
            $venue->setDescription($description);
            $venue->setAddress($address);
            $venue->setVenueManager($venue_manager);
            $venue->setEmail($email);
            $venue->setCapacity($capacity);
            $venue->setCreatedDate($created_date);
            $venue->setStatus(1);

            /*
             * Insert Venue
             */
            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            /*
             * Insert Queue
             */
            $email = new EmailQueue;
            $email->setEmail($form['email']->getData());
            $email->setProcessDate($created_date);
            $email->setSentDate($created_date);

            $em->persist($email);
            $em->flush();

            $this->addFlash(
                'notice',
                'Venue Added'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('VenuesBundle:Default:create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/view/{id}", name="view_venue")
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $venue = $em->getRepository('VenuesBundle:Venues')->find($id);

        return $this->render('VenuesBundle:Default:view.html.twig', ['venue' => $venue]);
    }

    /**
     * @Route("/update/{id}", name="update_venue")
     */
    public function updateAction($id, Request $request)
    {
        $venue = $this->getDoctrine()->getRepository('VenuesBundle:Venues')->find($id);

        $venue->setName($venue->getName());
        $venue->setvenueType($venue->getVenueType());
        $venue->setDescription($venue->getDescription());
        $venue->setAddress($venue->getAddress());
        $venue->setVenueManager($venue->getVenueManager());
        $venue->setEmail($venue->getEmail());
        $venue->setCapacity($venue->getCapacity());

        $form = $this->createFormBuilder($venue)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('venue_type', ChoiceType::class, array('choices' => ['Office' => 'Office', 'Hotel' => 'Hotel'], 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextAreaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('address', TextAreaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('venue_manager', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('capacity', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Update Venue', 'attr' => array('class' => 'btn btn-info', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $venue_type = $form['venue_type']->getData();
            $description = $form['description']->getData();
            $address = $form['address']->getData();
            $venue_manager = $form['venue_manager']->getData();
            $email = $form['email']->getData();
            $capacity = $form['capacity']->getData();

            $venue->setName($name);
            $venue->setVenueType($venue_type);
            $venue->setDescription($description);
            $venue->setAddress($address);
            $venue->setVenueManager($venue_manager);
            $venue->setEmail($email);
            $venue->setCapacity($capacity);

            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            $this->addFlash(
                'notice',
                'Venue Updated'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('VenuesBundle:Default:update.html.twig', ['form' => $form->createView(), 'venue_name' => $venue->getName()]);
    }

    /**
     * @Route("/delete/{id}/{confirm}", name="delete_venue")
     */
    public function deleteAction($id, $confirm = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $venue = $em->getRepository('VenuesBundle:Venues')->find($id);

        if($confirm){
            $em->remove($venue);
            $em->flush();

            $this->addFlash(
                'notice',
                'Venue Removed'
            );
            return $this->redirectToRoute('home');
        }

        return $this->render('VenuesBundle:Default:delete.html.twig', [ 'venue' => $venue]);
    }

}
