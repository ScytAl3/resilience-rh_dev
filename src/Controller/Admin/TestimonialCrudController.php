<?php

namespace App\Controller\Admin;

use App\Entity\Testimonial;
use App\Repository\SolutionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TestimonialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Testimonial::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID')->onlyOnIndex();
        // Témoignage relation
        $solution = AssociationField::new('solution')
            ->setFormTypeOptions(
                [
                    'required' => 'required'
                ],
                [
                    'query_builder' => function (SolutionRepository $sr) {
                        return $sr->createQueryBuilder('p')
                            ->orderBy('p.label', 'ASC');
                    },
                ]
            )
            ->setSortable(true)
            ->setTextAlign('right');
        // Initials
        $initials = TextField::new('initials', 'Initiales');
        // Mérier
        $job = TextField::new('job', 'Métiers');
        // Témoignages
        $testimony = TextEditorField::new('testimony', 'Témoignage')
            ->setNumOfRows(7);

        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $solution, $initials, $job, $testimony];
        }

        return [
            FormField::addPanel('Solution'),
            $solution,
            FormField::addPanel('Informations du témoignage'),
            $initials, $job, $testimony
        ];
    }
}
