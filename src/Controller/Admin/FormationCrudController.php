<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // id de la formation
        $id = IdField::new('id', 'ID')->hideOnForm();

        // Nom de la formation
        $name = TextField::new('name', 'Nom');

        // Nom de l'école
        $school = TextField::new('school', 'École');

        // Localisation
        $place = TextField::new('place', 'Ville');

        // URL de l'école
        $link = TextField::new('link', 'Site');

        // Description de la formation
        $description = TextEditorField::new('description', 'Description');

        // Date de début
        $startDate = DateTimeField::new('startDate', 'Date de début');

        // Date de fin
        $endDate = DateTimeField::new('endDate', 'Date de fin');

        // Compétence
        $skill = AssociationField::new('skill', 'Compétences');

        // Couleur
        $color = AssociationField::new('colors', 'Couleur');
        
        // Date de création
        $createdAt = DateTimeField::new('createdAt', 'Date de création')->hideOnForm();

        // Date de modification
        $updatedAt = DateTimeField::new('updatedAt', 'Date de modification')->hideOnForm();

        // Actuellement
        $actually = BooleanField::new('actually', 'Actuellement');

        // Option pour caché la formation
        $hidden = BooleanField::new('hidden', 'Caché');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $school, $place, $link, $startDate, $endDate, $color, $actually, $hidden];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $school, $place, $link, $description, $startDate, $endDate, $skill, $color, $createdAt, $updatedAt, $actually, $hidden];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $name, $school, $place, $link, $description, $startDate, $endDate, $skill, $color, $createdAt, $updatedAt, $actually, $hidden];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$id, $name, $school, $place, $link, $description, $startDate, $endDate, $skill, $color, $createdAt, $updatedAt, $actually, $hidden];
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Gestion des Formations')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setDateTimeFormat('dd/M/yy hh:mm:ss')
            ->setDateFormat('d/m/y')
            ->setPaginatorUseOutputWalkers(true)
            ->setPaginatorFetchJoinCollection(true)
            ->setPaginatorPageSize(10)
            ->setAutofocusSearch()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setCssClass('btn btn-primary')->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->setCssClass('btn btn-success')->setLabel('Consulter');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->setCssClass('btn btn-danger')->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel(false);
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-save')->setLabel('Enregistrer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setIcon('fa fa-save')->setLabel('Enregistrer & Créer');
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-arrow-right')->setLabel('Retour à la liste');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setIcon('fa fa-save')->setLabel('Enregistrer & Continuer');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-save')->setLabel('Enregistrer');
            })
        ;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::updateEntity($entityManager, $entityInstance);
    }
}
