<?php

namespace App\Form;
use App\Entity\Gazouillis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GazouillisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // null il trouve par default le type de champ input
            ->add('content',null,[

                'label' => 'Quoi de neuf ?',
                'required' => false,
                'attr' => [
                    'class' => 'field',
                    'placeholder' => 'Quoi de neuf ?',
                    'onkeyup' => 'count(this);validate();'
                ],
            ])
            ->add('category', null, ['choice_label' => 'name', 'attr'=>['onchange' => 'validate();']] );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // ici je relie le formulaire à l'ENTITY
            'data_class' => Gazouillis::class,
        ]);
    }
}
