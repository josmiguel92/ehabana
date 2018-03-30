<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImagenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('detalles')
            ->add('nombre_en', null, ["label"=>"Nombre[En]"])
            ->add('detalles_en', null, ["label"=>"Detalles[En]"])
            ->add('file', null, ["label"=>"Imagen"])
            ->add('active',null, ["label"=>"Activa en Home"])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Imagen'
        ));
    }
}
