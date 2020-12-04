<?php

namespace App\Controller\Admin;

use App\Entity\Citizen;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CitizenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Citizen::class;
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
        return $filters
            ->add(TextFilter::new('firstName'))
            ->add('lastName')
            ->add('phone')
            ->add(ChoiceFilter::new('gender')->setChoices(Citizen::$genderChoices))
            ->add(DateTimeFilter::new('dateOfBirth'));
    }

    public function configureFields(string $pageName): iterable
    {
        $imgFile = ImageField::new('thumbnailFile')->setFormType(VichImageType::class)->setLabel('Avatar');
        $imgName = ImageField::new('thumbnail')->setBasePath('/images/citizen/')->setLabel('Avatar');
        $fields = [
            TextField::new('firstName'),
            TextField::new('lastName'),
            TelephoneField::new('phone'),
            DateField::new('dateOfBirth'),
            ChoiceField::new('gender')->setChoices(Citizen::$genderChoices),
            AssociationField::new('apartmentId')->autocomplete()->setLabel('Apartment ID'),
        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $imgName;
            $fields[] = DateTimeField::new('createAt');
        } else {
            $fields[] = $imgFile;
        }
        return $fields;
    }
}
