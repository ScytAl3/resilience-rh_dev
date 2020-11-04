<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID')
            ->onlyOnIndex();
        // Informations sur l'offre d'emploi'
        $name = TextField::new('title', 'Titre de l\'offre');
        $isValid = BooleanField::new('isValid', 'En cours');
        $introduction = TextEditorField::new('introduction', 'Introduction')
            ->setNumOfRows(4);
        $contract = TextField::new('contract', 'Type de contrat');
        $presentation = TextEditorField::new('presentation', 'Le Poste')
            ->setNumOfRows(7);
        $mission = TextEditorField::new('mission', 'Mission')
            ->setNumOfRows(7);
        $profile = TextEditorField::new('profile', 'Profil')
            ->setNumOfRows(7);
        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $isValid, $presentation];
        }

        return [
            FormField::addPanel('Informations générales'),
            $isValid, $introduction, $name, $contract,
            FormField::addPanel('Détails de l\'offre'),
            $presentation, $mission, $profile,
        ];
    }
}
