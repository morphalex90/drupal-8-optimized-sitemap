<?php
namespace Drupal\optimized_sitemap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
#use Drupal\Core\Entity\EntityTypeBundleInfoInterface;

/**
 * Configure example settings for this site.
 */
class Options extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'optimized_sitemap_options';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'optimized_sitemap.options',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('optimized_sitemap.options');
	
	// oer caricarne solo una \Drupal::entityManager()->getBundleInfo($entity_type);
	
	#$entityTypes = \Drupal\Core\Entity\EntityTypeBundleInfoInterface::getAllBundleInfo(); // new and not deprecated but needs work
	$entityTypes = \Drupal::entityManager()->getAllBundleInfo(); // get all entities types
	foreach($entityTypes as $key => $entityType){
		drupal_set_message('test: '.$key);
	}

	## Nodes container
    /*$form['node'] = array(
      '#type' => 'details',
      '#title' => $this->t('Enable sitemap for node types'),
      '#open' => TRUE
    );
	
	$nodeTypes = \Drupal\node\Entity\NodeType::loadMultiple(); // load all the node content types

	foreach ($nodeTypes as $nodeType) {
		
		## Create a new option for each node type
		$form['node']['node_'.$nodeType->id()] = array(
		  '#type' => 'checkbox',
		  '#title' => $this->t($nodeType->label()),
		  '#default_value' => $config->get('node_'.$nodeType->id())
		);
		
		$nodeFields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', $nodeType->id());
		
		foreach ($nodeFields as $key => $nodeField) {
			
			if($nodeField->getType() == 'image'){

				$form['node']['field_'.$nodeField->id()] = array(
				  '#type' => 'checkbox',
				  '#title' => $this->t($nodeType->label().' -> '.$nodeField->getLabel()),
				  '#default_value' => $config->get('field_'.$nodeField->id())
				);
			}
		}	
	}*/
	

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	  
	$temp = $this->config('optimized_sitemap.options');
    
	$nodeTypes = \Drupal\node\Entity\NodeType::loadMultiple();
	foreach ($nodeTypes as $nodeType) {
		$temp->set('node_'.$nodeType->id(), $form_state->getValue('node_'.$nodeType->id()));
	}

      
    $temp->save();

    parent::submitForm($form, $form_state);
  }
}