<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieLieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class,[
                'date_format' => 'y M d',

                'with_minutes' => true,
                'with_seconds' => true,

            ])
            ->add('duree')
            ->add('nbInscriptionMax')
            ->add('infosSortie')
            ->add('dateLimiteInscription')
            ->add('lieu', EntityType::class,[
                "class" => Lieu::class,
                "choice_label" => "nom"
            ])
            ->add('site', EntityType::class, [
                "class" => Site::class,
                "choice_label" => "nom"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}