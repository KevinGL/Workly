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

    #[Route("/job_interview/view/{id}", name: "view_job_interview")]
    public function view(JobInterviewRepository $repo, int $id) : Response
    {
        $jobInterview = $repo->find($id);

        return $this->render("job_interview/view.html.twig",
        [
            "jobInterview" => $jobInterview
        ]);
    }

    #[Route("/job_interview/edit/{id}", name: "edit_job_interview")]
    public function edit(Request $req, CandidacyRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        $jobInterview = $repo->find($id);

        $form = $this->createForm(JobInterviewType::class, $jobInterview, ["edit" => true]);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($jobInterview);
            $em->flush();

            $this->addFlash("success", "Entretien d'embauche mis à jour");
            return $this->redirectToRoute("app_job_interview");
        }

        return $this->render("job_interview/edit.html.twig",
        [
            "form" => $form
        ]);
    }

    #[Route("/job_interview/delete/{id}", name: "delete_job_interview")]
    public function delete(JobInterviewRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        $jobInterview = $repo->find($id);

        $em->remove($jobInterview);
        $em->flush();

        $this->addFlash("success", "Entretien supprimé");
        return $this->redirectToRoute("app_job_interview");
    }
}
