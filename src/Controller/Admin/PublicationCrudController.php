<?php

namespace App\Controller\Admin;

use App\Entity\Publication;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PublicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Publication::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID')
            ->onlyOnIndex();
        // Publication image
        $imageFile = ImageField::new('imageFile')
            ->setLabel('Image (JPEG or PNG file)')
            ->setFormType(VichImageType::class)->setFormTypeOptions([
                'allow_delete' => true,
            ]);
        $image = ImageField::new('imageName', 'Image')
            ->setBasePath('uploads/publications');
        // Publication title
        $title = TextField::new('title', 'Titre de la formation');
        $description = TextEditorField::new('description', 'Description')
            ->setNumOfRows(10);
        $create = DateField::new('createdAt', 'Publiée le');
        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $image, $title, $description, $create];
        }

        return [
            FormField::addPanel('Image'),
            $imageFile,
            FormField::addPanel('Basic information'),
            $title, $description, $create
        ];
    }
}
