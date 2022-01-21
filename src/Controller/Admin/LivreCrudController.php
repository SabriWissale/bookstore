<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        if ('index' == $pageName) 
        {
            $fieldAuteur = ArrayField::new('auteurs');
         } 
         else 
         {
            $fieldAuteur = AssociationField::new('auteurs');
         }
         if ('index' == $pageName) 
        {
            $fieldGenre = ArrayField::new('genres');
         } 
         else 
         {
            $fieldGenre = AssociationField::new('genres');
         }
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('isbn'),
            TextField::new('titre'),
            NumberField::new('nombre_pages'),
            DateField::new('date_de_parution'),
            NumberField::new('note'),
            $fieldAuteur,
            $fieldGenre, 

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::NEW, 'ROLE_ADMIN')
                       ->setPermission(Action::DELETE, 'ROLE_ADMIN')
                       ->setPermission(Action::EDIT, 'ROLE_ADMIN');
    }
    
}
