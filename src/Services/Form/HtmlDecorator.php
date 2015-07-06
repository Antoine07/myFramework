<?php
/**
 * Description of HtmlDecorator
 *
 * @author antoine
 */
abstract class HtmlDecorator implements iHtmlElement {
    
    protected $element;
    public function __construct(iHtmlElement $input) {
        $this->element = $input;
    }
    public function getName() {
        return $this->element->getName();
    }
    public function __toString() {
        return $this->element->__toString();
    }
}