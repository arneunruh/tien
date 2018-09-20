<?php
/**
 * Created by PhpStorm.
 * User: arneunruh
 * Date: 20.09.18
 * Time: 07:45
 */

namespace Tien\Controller;

class TienController {

  public function prepparePrint($id){
    if(!is_int($id)){
      throw new \Exception("Input is not an Integer");
    }

    $firstItem = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem();
    $returnedTag = $firstItem::getGlsMessage();

    if($returnedTag === false || $returnedTag == '') {
      return false;
    }

    $tags = $this->parseIncomingTags($returnedTag);

    if(!is_array($tags)){
      throw new \Exception("Tags is not an Array");
    }

    $service = $firstItem::getService();

    if ($service == "business" || $service == "cash") {
      $glsService = Mage::getModel('glsbox/label_gls_business');
    } elseif ($service == "express") {
      $glsService = Mage::getModel('glsbox/label_gls_express');
    }

    if($glsService != null) {
      $glsService->importValues($tags);
      return $glsService->getData();
    }

    return false;
  }

  public function pereparePrintBuild($id){

    //https://refactoring.guru/replace-error-code-with-exception
    //replace return false with code exception
    if(!is_int($id)){
      throw new \Exception("Input is not an Integer");
    }

    //Helper Class
    $firstItem = MageDump::getFirstItem();
    //return fake string
    $returnedTag = $firstItem::getGlsMessage();
    //debugging in console TienTest
    //fwrite(STDERR, print_r($returnedTag, TRUE));

    if($returnedTag === false || $returnedTag == '') {
      return false;
    }

    $tags = $this->parseIncomingTags($returnedTag);
    //fwrite(STDERR, print_r($tags, TRUE));

    if(!is_array($tags)){
      throw new \Exception("Tags is not an Array");
    }

    $service = $firstItem::getService();
    //fwrite(STDERR, print_r($service, TRUE));

    if ($service == "business" || $service == "cash") {
      $glsService = MageDump::getModel('glsbox/label_gls_business');
    } elseif ($service == "express") {
      $glsService = MageDump::getModel('glsbox/label_gls_express');
    }

    if($glsService != null) {
      $glsService->importValues($tags);
      return $glsService->getData();
    }

    return false;

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

  private function parseIncomingTags($string){

    return explode(",",$string);

  }

}