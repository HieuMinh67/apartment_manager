<?php

namespace App\Controller\Admin;

use App\Entity\Citizen;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CitizenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Citizen::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName'),
            TextField::new('lastName'),
            TelephoneField::new('phone'),
            DateField::new('dateOfBirth')->addCssClass('w-100'),
            ChoiceField::new('gender')->setChoices(['Male' => 0, 'Female' => 1, 'Other' => 2]),
            AssociationField::new('apartmentId')->autocomplete()
        ];
    }
}
