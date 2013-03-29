<?php
namespace Success\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
                  
class TreeType extends AbstractType
{
  protected $container;
  protected $subject;  
  protected $admin;
  protected $uniqid;


  public function __construct($container, $admin) {
    $this->container = $container;
    $this->admin = $admin;
    $this->subject = $admin->getSubject();
    $this->uniqid = $admin->getUniqid();
  }
  
  public function buildView(FormView $view, FormInterface $form, array $options) {
    $subject = $this->subject;
    $uniqid = $this->uniqid;

    $em = $this->container->get('doctrine')->getEntityManager();
    $repo = $em->getRepository('TestBundle:Category');    
    
    $options = array(
        'decorate' => true,
        'rootOpen' => '<ul id="tree">',
        'rootClose' => '</ul>',
        'childOpen' => '<li>',
        'childClose' => '</li>',
        'nodeDecorator' => function($node) use (&$subject, &$uniqid) {
            return '<input type="checkbox" value="' . $node['id'] . '" name="' . $uniqid . '[categories][]" ' . ($subject->hasCategory($node['id']) ? 'checked=checked' : '') . ' /><a href="/page/'.$node['slug'].'">'.$node['title'].'</a>';
        }
    );
    
    $htmlTree = $repo->childrenHierarchy(
        null,
        false,
        $options
    );
    
    $view->set('htmlTree', $htmlTree);    
  }
  
  public function getParent() {
    return 'entity';
  }

  public function getName() {
    return 'tree';
  }
}
