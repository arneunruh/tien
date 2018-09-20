# HowTo Refactoring with Simple Reversing

## The Function
Original
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
Refactoring
<pre>
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
</pre>  
  
## Variables - Stuff

$id

$returnedTag

$tags

$service

$glsService

### Avoid Duplicates

$firstItem

## Magento - Stuff

getModel()

Mage::getModel() will create a new instance of an object each time even such object exists in configuration.
getModel will always return a new instance of the requested model every time.

getCollection()

getData()

This method is used to get the relevant data from the object. 
$glsService->getData();

addFieldToFilter()

getFirstItem()

getGlsMessage()

getGLSService()

importValues()

## Private - Function

parseIncomingTag()

## Duplicates

<pre>
$returnedtag = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getGlsMessage();
$service = Mage::getModel('glsbox/shipment')->getCollection()->addFieldToFilter('id', $id)->getFirstItem()->getService();
</pre>

## Reversing

MageDump

## Refactoring and Testing

Validate the input id value type - int 

Validate the tags value type - array()

Remove Duplicates

Remove nested if/else 


## Sources

http://freegento.com/doc/d8/dcb/class_mage.html

https://github.com/vicboma1/refactoring 

https://wpshout.com/unconditionally-refactoring-nested-statements-cleaner-code/

https://refactoring.guru/refactoring/techniques/simplifying-conditional-expressions

https://refactoring.guru/replace-error-code-with-exception


## Book

Pro PHP Refactoring

## Debug

no xdebug

echo debug: <pre>fwrite(STDERR, print_r($args, TRUE));</pre>
