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
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE]);
    }

    public function configureFields(string $pageName): iterable
    {
        $imgFile = ImageField::new('thumbnailFile')->setFormType(VichImageType::class)->setLabel('Avatar');
        $imgName = ImageField::new('thumbnail')->setBasePath('/images/employee/')->setLabel('Avatar');
        $fields = [
            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email'),
//            ChoiceField::new('roles')->setChoices(['ADMIN' => ['ROLE_ADMIN'], 'MANAGER' => ['ROLE_MANAGER'], 'STAFF' => ['ROLE_STAFF']]),
            TelephoneField::new('phone'),
        ];
        if ($pageName == Crud::PAGE_DETAIL | $pageName == Crud::PAGE_INDEX) {
            $fields[] = $imgName;
        } else {
            $fields[] = $imgFile;
        }
        return $fields;
    }
}
