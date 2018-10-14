<?php
namespace Drupal\optimized_sitemap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class AdditionalSettings extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'optimized_sitemap_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'optimized_sitemap.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('optimized_sitemap.settings');

    $form['settings'] = array(
      '#type' => 'details',
      '#title' => $this->t('Settings'),
      '#open' => TRUE
    );
	
	$form['settings']['cron'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Re generate sitemap with cron'),
      '#default_value' => $config->get('cron')
    );
	
	$form['settings']['homepage_logo'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Add logo as image of homepage'),
      '#default_value' => $config->get('homepage_logo')
    );
	
	
    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->config('optimized_sitemap.settings')
      // Set the submitted configuration setting
      ->set('cron', $form_state->getValue('cron'))
      ->set('homepage_logo', $form_state->getValue('homepage_logo'))
      
      ->save();

    parent::submitForm($form, $form_state);
  }
}