<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class QuotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quotation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $archiveQuote = Action::new('archiveQuote', 'Archive', 'fa fa-archive')
        ->linkToCrudAction('quotationArchive');
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_DETAIL, $archiveQuote)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE])
            ->setPermissions([ Action::EDIT, 'ROLE_ADMIN', Action::DELETE, 'ROLE_ADMIN'])
            ->disable(Action::NEW)
    ;
    }

    public function quotationArchive(AdminContext $context)
    {
        $quotation = $context->getEntity()->getInstance();
        $quotation->setIsArchived(true);
        $quotation->setArchiveAt(new \DateTime('now'));
        dump($this->getUser()->getEmployee());
        exit();
        $quotation->setArchiveBy($this->getUser()->getEmployee()->addQuotation($quotation));
        $this->getDoctrine()->getManager()->flush();
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build()
            ->setAction(Action::INDEX)
            ->generateUrl();
        $this->addFlash("success", "Quote is archived");
        return $this->redirect($routeBuilder);
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
        $fields = array(
            IntegerField::new('id'),
            TextField::new('name'),
            DateTimeField::new('createAt')
        );
        if ($pageName != Crud::PAGE_INDEX) {
            $fields[] = TextareaField::new('message');
            $fields[] = TelephoneField::new('phone');
        }
        if ($pageName == Crud::PAGE_DETAIL) {
            $fields[] = BooleanField::new('isArchived');
        }
        if ($this->getUser()->getRoles()[0] != 'ROLE_ADMIN') {
            $fields = array_merge($fields, array(AssociationField::new('building'), EmailField::new('email')));
        } else {
            $fields = array_merge($fields, array(AssociationField::new('archiveBy'), DateTimeField::new('archiveAt')));
        }
        return $fields;
    }
}
