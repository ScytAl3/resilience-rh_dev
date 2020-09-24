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
        // Training image
        $imageFile = ImageField::new('pdfFile')
            ->setLabel('Image (JPEG or PNG file)')
            ->setFormType(VichImageType::class)->setFormTypeOptions([
                'allow_delete' => true,
            ]);
        $image = ImageField::new('pdfFilename', 'PDF')
            ->setBasePath('uploads/formations');
        // Training basic information
        $name = TextField::new('title', 'Nom de la formation');
        $description = TextEditorField::new('description', 'Description')
            ->setNumOfRows(7);
        $rh = BooleanField::new('humanResources', 'RH');
        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $image, $name, $description];
        }

        return [
            FormField::addPanel('Image'),
            $imageFile,
            FormField::addPanel('Basic information'),
            $name, $description, $rh
        ];
    }
}
