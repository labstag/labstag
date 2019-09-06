<?php

namespace Labstag\Form\Admin;

use Labstag\Entity\User;
use Labstag\Form\Admin\User\EmailType;
use Labstag\Form\Admin\User\PhoneType;
use Labstag\Lib\AbstractTypeLibAdmin;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilType extends AbstractTypeLibAdmin
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username');
        $builder->add('plainPassword');
        $builder->add(
            'emails',
            CollectionType::class,
            [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => EmailType::class,
            ]
        );
        $builder->add(
            'phones',
            CollectionType::class,
            [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => PhoneType::class,
            ]
        );
        $builder->add('imageFile', VichImageType::class);
        $builder->add('submit', SubmitType::class);
        unset($options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
