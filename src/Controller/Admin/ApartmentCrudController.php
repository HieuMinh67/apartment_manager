<?php

namespace App\Controller\Admin;

use App\Entity\Apartment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class ApartmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apartment::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('area')
            ->add(NumericFilter::new('price'))
            ->add(BooleanFilter::new('status'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IntegerField::new('area'),
            MoneyField::new('price')->setCurrency('VND'),
            AssociationField::new('citizenId')->autocomplete()->setLabel("Owner"),
            AssociationField::new('building')->autocomplete(),
        ];

        if ($pageName != Crud::PAGE_NEW) {
            $fields[] = BooleanField::new('status')->setLabel('Sold');
        }

        return $fields;
    }
}
