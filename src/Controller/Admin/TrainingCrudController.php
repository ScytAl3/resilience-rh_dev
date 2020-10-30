<?php

namespace App\Controller\Admin;

use App\Entity\Training;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TrainingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Training::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID')
            ->onlyOnIndex();
        // Informations sur le programme de la formation
        $name = TextField::new('title', 'Nom de la formation');
        $rh = BooleanField::new('humanResources', 'Formation RH');
        $description = TextEditorField::new('description', 'Objectif')
            ->setNumOfRows(7);
        $public = TextEditorField::new('public', 'Public')
            ->setNumOfRows(7);
        $pedagogie = TextEditorField::new('pedagogie', 'Pédagogie/Animation')
            ->setNumOfRows(7);
        $prerequis = TextEditorField::new('prerequis', 'Prérequis')
            ->setNumOfRows(7);
        $evaluation = TextEditorField::new('evaluation', 'Évaluation')
            ->setNumOfRows(7);
        // Informations sur la logistique de la formation
        $lieu = TextEditorField::new('lieu', 'Lieu')
            ->setNumOfRows(7);
        $duree = TextEditorField::new('duree', 'Durée')
            ->setNumOfRows(7);
        $langue = TextField::new('langue', 'Langue de la formation');
        $intervenant = TextEditorField::new('intervenant', 'Intervenant')
            ->setNumOfRows(7);
        $contact = TextEditorField::new('contact', 'Contact')
            ->setNumOfRows(7);
        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $rh, $description];
        }

        return [
            FormField::addPanel('Programme de la formation'),
            $rh, $name, $description, $public, $pedagogie, $prerequis, $evaluation,
            FormField::addPanel('Logistique de la formation'),
            $lieu, $duree, $langue, $intervenant, $contact,
        ];
    }
}
