<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quotation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE]);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new('building'))
                    ->add(DateTimeFilter::new('createAt'));
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IntegerField::new('id'),
            TextField::new('name'),
            TelephoneField::new('phone'),
            EmailField::new('email'),
            AssociationField::new('building'),
            DateTimeField::new('createAt')
        ];
        if ($pageName != Crud::PAGE_INDEX) {
            $fields[] = TextareaField::new('message');
        }
        return $fields;
    }
}
