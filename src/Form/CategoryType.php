<?php

namespace App\Form;

use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // null il trouve par default le type de champ input
            ->add('name',null,[

                'label' => 'Nom de la catégorie',
                'attr' => [
                    'class' => 'field',
                    'placeholder' => 'Nom de la catégorie',
                    'onkeyup' => 'countCate(this);validate();'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // ici je relie le formulaire à l'ENTITY
            'data_class' => Category::class,
        ]);
    }
}
