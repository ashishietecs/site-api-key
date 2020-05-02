<?php

namespace Drupal\site_api_key\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Class ExtendedSiteInformationForm
 * @package Drupal\site_api_key\Form
 */
class ExtendedSiteInformationForm extends SiteInformationForm {
 
  /**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state) {

	  $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    // Adding siteapikey text input field
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: t('No API Key yet'),
			'#description' => t("Custom field to set the API Key"),
    ];   
    // Change form submit button text to 'Update Configuration'
    $form['actions']['submit']['#value'] = t('Update configuration');	
		return $form;

	}
	
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('system.site')
		  ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
      // Add message that Site API Key has been set
      \Drupal::messenger()->addStatus("Successfully set Site API Key to " . $form_state->getValue('siteapikey'));
		  parent::submitForm($form, $form_state);
      
	}
}