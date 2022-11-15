<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')
                ->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            TextField::new('cover', 'Image de couverture'),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            TextareaField::new('content', 'Contenu')
                ->hideOnIndex(),
            DateTimeField::new('startDate', 'Date de début'),
            DateTimeField::new('endDate', 'Date de fin'),
            AssociationField::new('categories', 'Catégories'),
            AssociationField::new('tags', 'Tags'),
            DateTimeField::new('createdAt', 'Date de création')
                ->onlyOnIndex(),
            DateTimeField::new('createdAt', 'Date de modification')
                ->onlyOnIndex(),
            BooleanField::new('hidden', 'Caché'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
        ;
    }
}
