<?php

namespace App\Form;

use App\Entity\JobOffer;
use App\Entity\Candidature;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CandidatureType extends AbstractType
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
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
            ])
            ->add('jobOffer', EntityType::class, [
                'mapped' => false,
                'required' => false,
                'placeholder' => 'Candidature spontanée',
                'class' => JobOffer::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isValid = true')
                        ->orderBy('u.title', 'ASC');
                },
                'choice_label' => 'title',
            ])
            ->add('uploadFile', FileType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Votre fichier',
                'help' => 'Joindre votre CV (maxi 2 GO)',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'help' => 'maxi 2000 carcatères',
                'attr' => ['rows' => 10, 'cols' => 50],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'En soumettant ce formulaire, j’accepte que mes informations soient utilisées exclusivement dans le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler si je le souhaite.',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
