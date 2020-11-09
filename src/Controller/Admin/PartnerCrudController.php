<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PartnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID')
            ->onlyOnIndex();
        // Partner image
        $imageFile = ImageField::new('imageFile')
            ->setLabel('Image (JPEG or PNG file)')
            ->setHelp('idéalement de dimension 400x400')
            ->setFormType(VichImageType::class)->setFormTypeOptions([
                'allow_delete' => false,
                'required' => true,
            ]);
        $image = ImageField::new('imageName', 'Logo')
            ->setBasePath('uploads/partenaires');
        // Partner basic information
        $name = TextField::new('title', 'nom partenaire');
        $url = TextField::new('url', 'url');

        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $image, $name, $url];
        }

        return [
            FormField::addPanel('Image'),
            $imageFile,
            FormField::addPanel('Basic information'),
            $name, $url,
        ];
    }
}
