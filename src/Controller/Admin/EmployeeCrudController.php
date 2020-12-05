<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
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

//    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
//    {
//        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
//
//        dump($qb);
//        exit();
//        if (array_key_exists('ROLE_ADMIN', $context->getEntity()->getInstance()->getUser()->getRoles()) && $this->isGranted('ROLE_ADMIN')) {
//            return $qb;
//        }
//
//        $qb->leftJoin('entity.user', 'u')
//            ->Where('u.roles NOT LIKE :role')
//            ->setParameter('role', '%ROLE_ADMIN%');
//        return $qb;
//    }
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
//        dump($entityDto);
//        exit();
        $result = parent::createEditFormBuilder($entityDto, $formOptions, $context); // TODO: Change the autogenerated stub
        if (array_key_exists('ROLE_ADMIN', $entityDto->getInstance()->getUser()->getRoles()) & $this->isGranted('ROLE_ADMIN')) {
            return $result;
        }
        throw new AccessDeniedException();
    }

//    public function edit(AdminContext $context)
//    {
////        dump(array_key_exists('ROLE_ADMIN', $context->getEntity()->getInstance()->getUser()->getRoles()));
////        exit();
//        $result = parent::edit($context); // TODO: Change the autogenerated stub
//        if (array_key_exists('ROLE_ADMIN', $context->getEntity()->getInstance()->getUser()->getRoles()) && $this->isGranted('ROLE_ADMIN')) {
//            return $result;
//        }
//        return $result
//    }

//    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
//    {
//        $result = parent::createEditForm($entityDto, $formOptions, $context); // TODO: Change the autogenerated stub
//        if (array_key_exists('ROLE_ADMIN', $entityDto->getInstance()->getUser()->getRoles()) && $this->isGranted('ROLE_ADMIN')) {
//            throw new AccessDeniedException();
//        }
//        return $result;
//    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE]);
        if ($this->isGranted('ROLE_ADMIN')) {
            $actions->setPermissions([Action::NEW => 'ROLE_ADMIN', Action::EDIT, 'ROLE_ADMIN', Action::DELETE, 'ROLE_ADMIN']);
        } elseif ($this->isGranted('ROLE_MANGER')) {
            $actions->setPermissions([Action::NEW => 'ROLE_ADMIN', Action::EDIT, 'ROLE_ADMIN', Action::DELETE, 'ROLE_ADMIN']);
        }
        return $actions;
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
        yield AssociationField::new('user')->hideOnDetail()->hideOnForm()->hideOnIndex();
    }
}
