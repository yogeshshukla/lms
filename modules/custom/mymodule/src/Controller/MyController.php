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
    $values = \Drupal::entityQuery('node')
      ->condition('field_course', $cid)
      ->condition('uid', \Drupal::currentUser()->id())
      ->execute();
    if(!empty($values)){
      $result = \Drupal::entityQuery("node")
      ->condition('field_course', $cid)
      ->condition('uid', \Drupal::currentUser()->id())
      ->execute();
  
      $storage_handler = \Drupal::entityTypeManager()->getStorage("node");
      $entities = $storage_handler->loadMultiple($result);
      $storage_handler->delete($entities);
      drupal_set_message(t('You have successfully Unsubscribed'), 'status');       
    } else {
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
    }
    return new RedirectResponse("/lms/courses");
  }
}
