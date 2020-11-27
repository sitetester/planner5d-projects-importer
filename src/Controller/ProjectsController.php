<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Service\Project\QRCode\QRCodeManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projects", name="projects")
 */
class ProjectsController extends AbstractController
{
    private ProjectRepository $projectRepository;
    private EntityManagerInterface $entityManager;
    private QRCodeManager $qrCodeManager;

    public function __construct(
        ProjectRepository $projectRepository,
        EntityManagerInterface $entityManager,
        QRCodeManager $qrCodeManager
    ) {
        $this->projectRepository = $projectRepository;
        $this->entityManager = $entityManager;
        $this->qrCodeManager = $qrCodeManager;
    }

    /**
     * Name of this route is `projects_index` (php bin/console debug:router)
     * @Route("/{pageNum}", name="_index", requirements={"pageNum"="\d+"})
     * @param int $pageNum
     * @return Response
     */
    public function index(int $pageNum = 1): Response
    {
        $projectsPerPage = 5;
        $projectsCount = $this->projectRepository->getProjectsCount();
        $projects = $this->projectRepository->findBy([], null, $projectsPerPage, $pageNum);

        return $this->render(
            'projects/index.html.twig',
            [
                'projects' => $projects,
                'maxNum' => $projectsCount / $projectsPerPage,
                'projectsPerPage' => $projectsPerPage,
                'pageNum' => $pageNum,
            ]
        );
    }

    /**
     * @Route("/preview/{hash}", name="_preview")
     * @param string $hash
     * @return Response
     */
    public function preview(string $hash): Response
    {
        $project = $this->projectRepository->findOneBy(['hash' => $hash]);
        if (!$project) {
            throw $this->createNotFoundException(
                'No project found for hash ' . $hash
            );
        }

        $project->setHits($project->getHits() + 1);
        $this->entityManager->flush();

        $this->qrCodeManager->generateCode($project);

        return $this->render(
            'projects/preview.html.twig',
            [
                'project' => $project,
            ]
        );
    }
}
