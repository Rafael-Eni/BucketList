<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}


//#[Route('/populatedb', name: '_populate')]
//    public function populate(EntityManagerInterface $manager): Response
//{
//    $liste_de_seau = [
//        [
//            "title" => "Parcourir la Route 66 à moto et vivre une aventure légendaire sur les routes américaines.",
//            "description" => "Découvrez la liberté absolue en chevauchant votre moto le long de la Route 66, la mythique 'Mother Road' qui traverse les États-Unis d'est en ouest. Imprégnez-vous de l'histoire, de la culture et des paysages variés tout au long de ce voyage inoubliable.",
//            "author" => "John Doe",
//            "isPublished" => false
//        ],
//        [
//            "title" => "Faire de la plongée sous-marine dans la Grande Barrière de Corail pour explorer un monde sous-marin fascinant.",
//            "description" => "Explorez les eaux cristallines de la Grande Barrière de Corail, l'une des merveilles naturelles les plus spectaculaires du monde. Nagez parmi les poissons tropicaux colorés, les tortues de mer majestueuses et les coraux éblouissants lors de cette aventure de plongée inoubliable.",
//            "author" => "Jane Smith",
//            "isPublished" => false
//        ],
//        [
//            "title" => "Assister à un spectacle en direct dans un théâtre emblématique de Broadway à New York.",
//            "description" => "Vivez la magie du théâtre à Broadway, le cœur battant de l'industrie du spectacle à New York. Assistez à une représentation en direct d'une comédie musicale ou d'une pièce de théâtre primée et laissez-vous emporter par la performance, la musique et la danse.",
//            "author" => "Alice Johnson",
//            "isPublished" => true
//        ],
//        [
//            "title" => "Faire un voyage en montgolfière au lever du soleil et admirer le paysage depuis les cieux.",
//            "description" => "Prenez de la hauteur et vivez une expérience de montgolfière magique au lever du soleil. Flottez doucement dans le ciel, survolez les paysages pittoresques et admirez les couleurs vives du lever de soleil lors de cette aventure aérienne inoubliable.",
//            "author" => "David Williams",
//            "isPublished" => true
//        ],
//        [
//            "title" => "Faire une randonnée jusqu'au sommet du Machu Picchu et contempler l'ancienne cité inca au lever du jour.",
//            "description" => "Parcourez les sentiers ancestraux des Incas et atteignez le sommet du Machu Picchu, l'une des sept merveilles du monde moderne. Contemplez les ruines mystiques de cette ancienne cité inca et laissez-vous émerveiller par les vues panoramiques spectaculaires sur les montagnes environnantes.",
//            "author" => "Michael Brown",
//            "isPublished" => false
//        ],
//    ];
//
//    foreach ($liste_de_seau as $item) {
//        $wish = new Wish();
//        $wish->setTitle($item['title']);
//        $wish->setDescription($item['description']);
//        $wish->setAuthor($item['author']);
//        $wish->setIsPublished($item['isPublished']);
//        $wish->setDateCreated(new \DateTime());
//
//        $manager->persist($wish);
//    }
//
//    $manager->flush();
//
//    return $this->redirectToRoute('/wish');
//}