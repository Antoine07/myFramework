<?php

namespace Services\Form;

class LabelDecorator {
    protected $label;
    public function setLabel($label) {
        $this->label = $label;
    }
    public function __toString() {
        $name = $this->getName();
        return "<label for=\"{$name}\">{$this->label}</label>\n"
        . $this->element->__toString();
    }
}
