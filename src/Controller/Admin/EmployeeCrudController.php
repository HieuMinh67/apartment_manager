<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE])
            ->setPermissions([Action::NEW => 'ROLE_ADMIN', Action::EDIT, 'ROLE_ADMIN', Action::DELETE, 'ROLE_ADMIN']);
    }

    public function configureFields(string $pageName): iterable
    {
        $imgFile = ImageField::new('thumbnailFile')->setFormType(VichImageType::class)->setLabel('Avatar');
        $imgName = ImageField::new('thumbnail')->setBasePath('/images/employee/')->setLabel('Avatar');
        if ($pageName == Crud::PAGE_INDEX) {
            yield IntegerField::new('id');
        }
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield TelephoneField::new('phone');
        if ($pageName == Crud::PAGE_DETAIL | $pageName == Crud::PAGE_INDEX) {
            yield EmailField::new('user.email')->setLabel('Email');
            yield $imgName;
        } else {
            yield $imgFile;
        }
    }
}
