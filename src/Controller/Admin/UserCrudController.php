<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // Critical informations
        $id = IntegerField::new('id', 'ID')->onlyOnIndex();
        $email = TextField::new('email', 'Adresse email');
        $role = 
        // Basic information
        $createdAt = DateTimeField::new('createdAt', 'Created At');

        // Si page index on affiche les informations que l'on souhaite
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $createdAt];
        }

        return [
            FormField::addPanel('Informations sur les comptes'),
            $email, $createdAt,

        ];
    }
    
}
