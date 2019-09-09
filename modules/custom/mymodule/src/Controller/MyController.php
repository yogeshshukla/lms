<?php
/**
 * This is out My controller class
 *
 * @category  Module
 * @package   Module
 * @author    Yogesh 
 * @copyright 2019 Name
 * @license   MIT http://url.com
 * @link      http://url.com
 */

namespace Drupal\mymodule\Controller;

use \Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
class MyController {

  public function subscribe ( $cid )
  {
    $node = Node::create([
      'type'  => 'enrollment',
      'title' => 'Subscribed',
      'body'  => 'abc',
      'field_course' =>[
        'target_id' => $cid
      ],
      'field_student' =>[
        'target_id' => \Drupal::currentUser()->id()
      ],
      'uid' => \Drupal::currentUser()->id(),
    ]);
    $node->save();
    drupal_set_message(t('You have successfully subscribed'), 'status');
    return new RedirectResponse("/lms/courses");
  }
}
