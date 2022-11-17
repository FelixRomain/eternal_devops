<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
      $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // id de la personne
        $id = IdField::new('id', 'ID')->hideOnForm();

        // Nom de la personne
        $fullName = TextField::new('fullName', 'Nom complet');

        // Adresse email de la personne
        $email = EmailField::new('email', 'Adresse Email');

        // Roles dans symfony
        $roles = ChoiceField::new('roles', "Rôle")
            ->setChoices(['Administrateur' => 'ROLE_ADMIN', 'Utilisateur' => 'ROLE_USER'])
            ->allowMultipleChoices(true);

        // Password de la personne
        $password = TextField::new('plain_password', 'Mot de passe')
            ->setFormType(PasswordType::class)
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms();

        // Date de création
        $createdAt = DateTimeField::new('createdAt', 'Date de création')->hideOnForm();

        // Date de modification
        $updatedAt = DateTimeField::new('updatedAt', 'Date de modification')->hideOnForm();

        // Option pour caché l'utilisateur
        $hidden = BooleanField::new('hidden', 'Caché');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $fullName, $email, $roles, $createdAt, $updatedAt, $hidden];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $createdAt, $updatedAt, $hidden];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $createdAt, $updatedAt, $hidden];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $createdAt, $updatedAt, $hidden];
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Gestion des Utilisateurs')
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(User $user)
    {
        if ($user->getPassword() !== null) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
        }
    }
}
