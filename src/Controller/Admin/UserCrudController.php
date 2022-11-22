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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
        
        // Description de la personne
        $about = TextareaField::new('about', 'Description');

        // CV de la personne
        $fileName = ImageField::new('filename', 'Télécharger le CV')
            ->setBasePath(' uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(true);

        // Compétence de l'utilisateur
        $skill = AssociationField::new('skills', 'Compétences');

        // Formation de l'utilisateur
        $formation = AssociationField::new('formations', 'Formations');

        // Expérience de l'utilisateur
        $experience = AssociationField::new('experiences', 'Expériences');

        // Projet de l'utilisateur
        $project = AssociationField::new('projects', 'Projets');

        // Date de création
        $createdAt = DateTimeField::new('createdAt', 'Date de création')->hideOnForm();

        // Date de modification
        $updatedAt = DateTimeField::new('updatedAt', 'Date de modification')->hideOnForm();

        // Option pour afficher l'utilisateur en Front
        $front = BooleanField::new('front', 'Principal');

        // Option pour caché l'utilisateur
        $hidden = BooleanField::new('hidden', 'Caché');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $fullName, $email, $roles, $createdAt, $updatedAt, $front, $hidden];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $about, $fileName, $formation, $experience, $skill, $project, $createdAt, $updatedAt, $front, $hidden];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $about, $fileName, $formation, $experience, $skill, $project, $createdAt, $updatedAt, $front, $hidden];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$id, $fullName, $email, $roles, $password, $about, $fileName, $formation, $experience, $skill, $project, $createdAt, $updatedAt, $front, $hidden];
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

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));

        return $user;
    }

    private function encodePassword(User $user)
    {
        if ($user->getPassword() !== null) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
        }
    }
}
