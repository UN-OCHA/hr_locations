<?php

/**
 * @file
 * Contains \RestfulEntityTaxonomyTermLocations.
 */

class RestfulEntityTaxonomyTermLocations extends \RestfulEntityBaseTaxonomyTerm {

  /**
   * Overrides \RestfulEntityBase::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['pcode'] = array(
      'property' => 'field_pcode',
    );

    $public_fields['parents'] = array(
      'callback' => array($this, 'getParents'),
    );

    $public_fields['admin_level'] = array(
      'callback' => array($this, 'getAdminLevel'),
    );

    $public_fields['geolocation'] = array(
      'callback' => array($this, 'getGeolocation'),
    );

    return $public_fields;
  }

  protected function getParents($wrapper) {
    $labels = array();
    foreach ($wrapper->parents_all->getIterator() as $delta => $term_wrapper) {
      $labels[] = $this->getEntitySelf($term_wrapper);
    }
    return $labels;
  }

  protected function getAdminLevel($wrapper) {
    $count = 0;
    foreach ($wrapper->parents_all->getIterator() as $delta => $term_wrapper) {
      $count++;
    }
    return $count - 1;
  }

  protected function getGeolocation($wrapper) {
    $geofield = $wrapper->field_geofield->value();
    return array('lat' => $geofield['lat'], 'lon' => $geofield['lon']);
  }
}
