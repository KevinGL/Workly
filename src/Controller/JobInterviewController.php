<?php

namespace App\Controller;

use App\Entity\JobInterview;
use App\Form\JobInterviewType;
use App\Repository\CandidacyRepository;
use App\Repository\JobInterviewRepository;
use App\Repository\SocietyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobInterviewController extends AbstractController
{
    #[Route('/job_interview', name: 'app_job_interview')]
    public function index(JobInterviewRepository $repo): Response
    {
        $jobInterviews = $repo->findAll();
        
        return $this->render('job_interview/index.html.twig',
        [
            'jobInterviews' => $jobInterviews
        ]);
    }

    #[Route("/job_interview/add", name: "add_job_interview")]
    public function add(Request $req, CandidacyRepository $candRepo, SocietyRepository $socRepo, EntityManagerInterface $em): Response
    {
        $jobInterview = new JobInterview();

        if($req->get("candidacyID"))
        {
            $cand = $candRepo->find($req->get("candidacyID"));
            
            $jobInterview->setJob($cand->getJob());
            $jobInterview->setSociety($cand->getSociety());
            $jobInterview->setAbout($cand->getAbout() ?? "");
            $jobInterview->setCandidacyType("Offre d'emploi");
        }
        else
        if($req->get("societyID"))
        {
            $society = $socRepo->find($req->get("societyID"));
            
            $jobInterview->setSociety($society->getName());
            $jobInterview->setAbout($society->getAbout() ?? "");
            $jobInterview->setPhoneNumber($society->getPhoneNumber() ?? "");
            $jobInterview->setEmail($society->getEmail() ?? "");
            $jobInterview->setLinkedIn($society->getLinkedIn() ?? "");
            $jobInterview->setCandidacyType("Candidature spontanée");
        }

        $form = $this->createForm(JobInterviewType::class, $jobInterview);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($jobInterview);
            $em->flush();

            $this->addFlash("success", "Entretien d'embauche ajouté");
            return $this->redirectToRoute("app_job_interview");
        }

        return $this->render("job_interview/add.html.twig",
        [
            "form" => $form
        ]);
    }
}
