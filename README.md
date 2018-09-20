#HowTo

##The Function

<pre>
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
</pre>

##Magento - Stuff

getModel()

getCollection()

addFieldToFilter()

getFirstItem()

getGlsMessage()

getGLSService()

importValues()

##Private - Function

parseIncomingTag()

##Duplicates

<pre>
$returnedtag = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getGlsMessage();
$service = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getService();
</pre>

##Refactoring and Testing

Validate the input id value type - int 
Validate the tags value type - array()
Remove Duplicates
Remove nested if/else 


## Sources

https://github.com/vicboma1/refactoring 
https://wpshout.com/unconditionally-refactoring-nested-statements-cleaner-code/
https://refactoring.guru/refactoring/techniques/simplifying-conditional-expressions
https://refactoring.guru/replace-error-code-with-exception

## Book

Pro PHP Refactoring