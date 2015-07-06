<?php
namespace Services\Form;

class Wrapper {
    protected $className="control-group";
    public function setClassName($className) {
        $this->className = $className;
    }
    public function __toString() {
        $name = $this->getName();
        return "<div class=\"{$this->className}\">".$this->element->__toString()."</div>\n";
    }
}
