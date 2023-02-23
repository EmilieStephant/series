<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

//Attribut de la classe directement, qui permet de mutualiser le début de l'URL et du nom
#[Route('/serie', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(SerieRepository $serieRepository): Response
    {
        //on récupère toutes les séries en passant par le repository
         $series = $serieRepository->findAll();

        //$series = $serieRepository->findBy(["status"=>"ended"], ["popularity" => 'DESC'], 10, 10);    //Tri par popularité descendante
        //$series = $serieRepository->findBy([], ["vote" => 'DESC'], 50);    //Tri par vote, on récupère les 50 meilleurs

        //$series = $serieRepository->findByStatus("ended");    //Méthode magique de Symfony : on peut écrire findBy suivi du nom de n'importe quel attribut
                                                                //On met ensuite le nom de l'attribute entre parenthèses
                                                                //Pourtant, la méthode n'existe pas dans le repository, Symfony la comprend et la crée dynamiquement

        $series = $serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig', [
            //on envoie tout à la vue
            "series" => $series
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])] //id doit être égal à un entier d'au moins un chiffre
    public function show(int $id, SerieRepository $serieRepository): Response
    //Il aurait été possible d'écrire en paramètre : Serie $id. Ce qui veut dire que je récupère l'ensemble de l'objet à partir de son id,
        // la récupération se fait automatiquement grâce au ParamConverter
    {
        $serie = $serieRepository->find($id);

        if (!$serie)
            //Lance une erreur 404 si la série n'existe pas
            throw $this->createNotFoundException("Oops ! Serie not found !");

        return $this->render('serie/show.html.twig',
        ["serie"=> $serie]);
    }

    #[Route('/add', name: 'add')]
    public function add(SerieRepository $serieRepository, EntityManagerInterface $entityManager): Response
        //L'instance de SerieRepository est préconstruite par Symfony
        // lorque je lui précise que j'en ai besoin d'une ... magie !
        //Cette instance est un Singleton !
    {
        $serie = new Serie();
        $serie2 = new Serie();
        $serie3 = new Serie();

        $serie
            ->setName("The Office")
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres("Comedy")
            ->setFirstAirDate(new \DateTime('2005-03-24'))
            ->setLastAirDate(new \DateTime('-6 month'))
            ->setPopularity(850.52)
            ->setPoster("poster.png")
            ->setTmdbId(123456)
            ->setVote(8.5)
            ->setStatus("Ended");

        $serie2
            ->setName("Le magicien")
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres("Comedy")
            ->setFirstAirDate(new \DateTime('2005-03-24'))
            ->setLastAirDate(new \DateTime('-6 month'))
            ->setPopularity(850.52)
            ->setPoster("poster.png")
            ->setTmdbId(123456)
            ->setVote(8.5)
            ->setStatus("Ended");

        $serie3
            ->setName("Le bureau des légendes")
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres("Comedy")
            ->setFirstAirDate(new \DateTime('2005-03-24'))
            ->setLastAirDate(new \DateTime('-6 month'))
            ->setPopularity(850.52)
            ->setPoster("poster.png")
            ->setTmdbId(123456)
            ->setVote(8.5)
            ->setStatus("Ended");

/*        dump($serie);

        //Enregistrement en BDD, mise à jour automatique de l'id dans l'objet $serie
        $serieRepository->save($serie, true);

        $serie->setName("The Last of Us");          //A partir du moment où il y a un id, il comprend tout seul qu'il s'agit d'un update et non d'un create
        $serieRepository->save($serie, true);

        dump($serie);*/

        $entityManager->persist($serie);
        $entityManager->persist($serie2);
        $entityManager->persist($serie3);
        $entityManager->flush();

        $serieRepository->remove($serie2, true);

        //TODO Créer un formulaire d'ajout de série

        return $this->render('serie/add.html.twig');
    }


}
