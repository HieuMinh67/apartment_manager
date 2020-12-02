<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE])
            ->setPermissions([Action::NEW => 'ROLE_ADMIN', Action::EDIT, 'ROLE_ADMIN', Action::DELETE, 'ROLE_ADMIN']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id'),
            EmailField::new('email'),
            ChoiceField::new('roles')->setChoices(['Admin' => 'ROLE_ADMIN', 'Manager' => 'ROLE_MANAGER', 'Staff' => 'ROLE_STAFF']),
            ImageField::new('employee.thumbnail')->setBasePath('/images/employee/')->setLabel('Avatar'),
        ];
    }
}
