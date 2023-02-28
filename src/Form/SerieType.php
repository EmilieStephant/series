<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Image;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('overview', TextareaType::class, ["required" => false])   //par défaut, le required est à true
            ->add('status', ChoiceType::class, [
                "choices" => [
                    "Canceled" => "canceled",
                    "Ended" => "ended",
                    "Returning" => "returning"
                ],
                "multiple" => false,
                "expanded" => false
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genres', ChoiceType::class, [
                "choices" => [
                    "Western" => "western",
                    "Comedy" => "comedy",
                    "Drama" => "drama"
                ],
                "multiple" => false,
                "expanded" => false
            ])
            ->add('firstAirDate', DateType::class, [
                'label' => "First air date : ",
                "html5" => true,
                "widget" => "single_text"
            ])
            ->add('lastAirDate', DateType::class, [
                'label' => "Last air date : ",
                "html5" => true,
                "widget" => "single_text"
            ])
            ->add('backdrop')
            ->add('poster', FileType::class, [
                "mapped" => false,  //mapped false pour indiquer que l'élément ne prend pas le type indiqué dans l'attribut
                                    //Donc les contraintes éventuellement imposées à l'attribut ne sont pas prises en compte
                "constraints" => [
                    new Image([
                        "maxSize"=> '5000k',    //La limite de transfert d'image est souvent de 5 Mo
                        "mimeTypesMessage"=> "Format not allowed."
                    ])
                ]
            ])
            ->add('tmdbId')
          //  ->add('submit', SubmitType::class)    //Déconseillé par Symfony, il vaut mieux le faire dans le Twig
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
            'required' => false,            //Déscativation de l'option required true par défaut de HTML
        ]);
    }
}
