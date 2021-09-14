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

class ModifierSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class,[
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                // 'input_format' => 'Y-m-d H:i:s',
                'label_attr' => ['class' => 'labeldisplay'],
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('duree')
            ->add('nbInscriptionMax')
            ->add('infosSortie')
            ->add('dateLimiteInscription', DateTimeType::class,[
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'label' => "Limite inscription",
                'label_attr' => ['class' => 'labeldisplay inline'],
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                ],
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
