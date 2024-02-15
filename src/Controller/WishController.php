<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Wish;
use App\Form\WishType;
use App\Helper\CensureService;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/wish', name: 'wish')]
class WishController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function index(WishRepository $wishRepository): Response
    {

        $bucketList = $wishRepository->findAll();

        return $this->render('wish/index.html.twig', [
            'bucketList' => $bucketList
        ]);
    }

    #[Route('/{id}', name: '_detail', requirements: ['id' => '\d+'])]
    public function detail(Wish $bucket, WishRepository $wishRepository): Response
    {
        return $this->render('wish/detail.html.twig', [
            'bucket' => $bucket
        ]);
    }

    #[Route('/create', name: '_create')]
    #[Route('/update/{id}', name: '_update')]
    #[IsGranted("ROLE_USER")]
    public function create(Request $request, EntityManagerInterface $manager, ?Wish $bucket, SluggerInterface $slugger, CensureService $censureService): Response
    {
        $isEditMode = $bucket ? true : false;

        if(!$isEditMode) {
            $bucket = new Wish();
        }

        $bucketForm = $this->createForm(WishType::class, $bucket);
        $bucketForm->handleRequest($request);

        if($bucketForm->isSubmitted() && $bucketForm->isValid()) {

            if ($bucketForm->get('poster_file')->getData() instanceof UploadedFile) {
                $dir = $this->getParameter('poster_dir');
                $posterFile = $bucketForm->get('poster_file')->getData();
                $fileName = $slugger->slug($bucket->getId()) . '-' . uniqid() . '.' . $posterFile->guessExtension();
                $posterFile->move($dir, $fileName);

                if ($bucket->getPoster() && \file_exists($dir . '/' . $bucket->getPoster())) {
                    unlink($dir . '/' . $bucket->getPoster());
                }

                $bucket->setPoster($fileName);

            }

            $censoredTitle = $censureService->censure($bucket->getTitle());
            $censoredContent = $censureService->censure($bucket->getDescription());

            $bucket->setTitle($censoredTitle);
            $bucket->setDescription($censoredContent);

            if (!$isEditMode) {
                $manager->persist($bucket);
            }

            $manager->flush();
            $this->addFlash('success', 'Bucket crée avec succès');
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/form.html.twig', [
            'form' => $bucketForm
        ]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    #[IsGranted("ROLE_USER")]
    public function delete(Wish $wish, EntityManagerInterface $em): Response
    {

        $em->remove($wish);
        $em->flush();

        return $this->redirectToRoute('wish_list');
    }
}
