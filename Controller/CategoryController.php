<?php

namespace Success\CategoryBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class CategoryController extends Controller {
  
  /**
   * return the Response object associated to the list action
   *
   * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
   *
   * @return Response
   */
  public function listAction()
  {
      if (false === $this->admin->isGranted('LIST')) {
          throw new AccessDeniedException();
      }

      $datagrid = $this->admin->getDatagrid();
      $formView = $datagrid->getForm()->createView();

      // set the theme for the current Admin Form
      $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

      $em = $this->get('doctrine')->getEntityManager();
      $repo = $em->getRepository('CategoryBundle:Category');      
      $list = $repo->getTree();
      
      return $this->render($this->admin->getTemplate('list'), array(
          'action'   => 'list',
          'form'     => $formView,
          'results'  => $list
      ));
  }

}