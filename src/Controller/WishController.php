<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $bucket = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'bucket' => $bucket
        ]);
    }

    #[Route('/create', name: '_create')]
    #[Route('/update/{id}', name: '_update')]
    public function create(Request $request, EntityManagerInterface $manager, ?Wish $bucket): Response
    {
        $isEditMode = $bucket ? true : false;

        if(!$isEditMode) {
            $bucket = new Wish();
        }

        $bucketForm = $this->createForm(WishType::class, $bucket);
        $bucketForm->handleRequest($request);

        if($bucketForm->isSubmitted() && $bucketForm->isValid()) {
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
    public function delete(Wish $wish, EntityManagerInterface $em): Response
    {

        $em->remove($wish);
        $em->flush();

        return $this->redirectToRoute('wish_list');
    }
}
