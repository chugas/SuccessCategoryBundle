<?php

namespace Success\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
//In order to use service for prePersist and preUpdate
use Symfony\Component\DependencyInjection\ContainerInterface;

class CategoryAdmin extends Admin {

  protected $datagridValues = array(
      '_per_page' => 1000
  );
  
  public function __construct($code, $class, $baseControllerName, ContainerInterface $container) {
    parent::__construct($code, $class, $baseControllerName);
    $this->container = $container;
  }
  
  public function getTemplate($name) {

    switch ($name) {
      case 'list':
        return 'CategoryBundle:Category:categorias.html.twig';
        break;
      default:
        return parent::getTemplate($name);
        break;
    }
  }

  /**
   * Create and Edit
   * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
   *
   * @return void
   */
  protected function configureFormFields(FormMapper $formMapper) {
    $em = $this->container->get('doctrine')->getEntityManager();
    $repo = $em->getRepository('CategoryBundle:Category');
    $query = $repo->getTreeQuery();

    $formMapper
            ->with('General')
            ->add('title', 'text')
            ->add('description', 'text')
            ->add('parent', 'entity', array(
                'class'       => 'CategoryBundle:Category',
                'multiple'    => false,
                'property'    => 'indentedTitle',
                'query_builder' => $query
            ))
            ->add('translations', 'a2lix_translations', array(
                'required' => false,
                'fields' => array(
                    'title' => array(
                        'label' => 'Titulo', // [optional] Custom label. Ucfirst, otherwise
                    ),
                    'description' => array(
                        'label' => 'Descripcion',
                        'attr' => array('style' => 'width:800px; height: 400px', 'class' => 'tinymce', 'data-theme' => 'medium', 'rows' => 20)
                    )
                )
            ))
            ->end()
    ;
  }

  /**
   * List
   * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
   *
   * @return void
   */
  protected function configureListFields(ListMapper $listMapper) {
    $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
    ;
  }

}