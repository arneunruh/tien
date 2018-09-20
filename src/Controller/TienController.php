<?php
/**
 * Created by PhpStorm.
 * User: arneunruh
 * Date: 20.09.18
 * Time: 07:45
 */

namespace Tien\Controller;

class TienController {

  public function pereparePrintAfter($id){

  }


  public function preparePrintBefore($id) {
    $returnedtag = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getGlsMessage();

    if($returnedtag === false || $returnedtag == '') {
      return false;
    } else {
      $tags = $this->parseIncomingTag($returnedtag);
      if(is_Array($tags)) {
        $service = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getService();
        if ($service == "business" || $service == "cash") {
          $glsService = Mage::getModel('glsbox/label_gls_business');
        } elseif ($service == "express") {
          $glsService = Mage::getModel('glsbox/label_gls_express');
        }

        if($glsService != null) {
          $glsService->importValues($tags);
          return $glsService->getData();
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }

}