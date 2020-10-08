<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom',
            ])
            ->add('email', EmailType::
            class, [
                'label' => 'Votre email',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre numéro de téléphone',
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Sujet',
                'choices' => [
                    'Choisir le sujet' => '',
                    'Formation' => 'Formation',
                    'Recrutement' => 'Recrutement',
                    'Bilan de compétences' => 'Bilan de compétences',
                    'Orientation' => 'Orientation',
                    'Carrière/CV' => 'Carrière/CV',
                    'Déposer votre candidature' => 'Déposer votre candidature',
                    'Autre' => 'Autre',
                ]
            ])
            ->add('uploadFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Votre fichier',
                'help' => 'Vous pouvez ajouter une piece jointe à votre demande (maxi 2 GO)',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'help' => 'maxi 2000 carcatères',
                'attr' => ['rows' => 10, 'cols' => 50],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
