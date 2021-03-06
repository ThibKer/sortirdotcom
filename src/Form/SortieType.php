<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class,[
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'label' => "Date début",
                'label_attr' => ['class' => 'labeldisplay'],
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('duree')
            ->add('nbInscriptionMax')
            ->add('infosSortie', TextareaType::class, [
                "required" => false
            ])
            ->add('dateLimiteInscription', DateTimeType::class,[
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'label' => "Limite inscription",
                'label_attr' => ['class' => 'labeldisplay'],
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                ],
            ])
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



