<?php

/* @Twig/Exception/exception.json.twig */
class __TwigTemplate_26c1ab0c01724e208e29f9b76afa48cc06bffaf37ded6f8419d714d355eff1f7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_306a08f5471778f4a1dc93c74869521553f696266269768718cbe8360aedd4d2 = $this->env->getExtension("native_profiler");
        $__internal_306a08f5471778f4a1dc93c74869521553f696266269768718cbe8360aedd4d2->enter($__internal_306a08f5471778f4a1dc93c74869521553f696266269768718cbe8360aedd4d2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.json.twig"));

        // line 1
        echo twig_jsonencode_filter(array("error" => array("code" => (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "message" => (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "exception" => $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "toarray", array()))));
        echo "
";
        
        $__internal_306a08f5471778f4a1dc93c74869521553f696266269768718cbe8360aedd4d2->leave($__internal_306a08f5471778f4a1dc93c74869521553f696266269768718cbe8360aedd4d2_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.json.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {{ { 'error': { 'code': status_code, 'message': status_text, 'exception': exception.toarray } }|json_encode|raw }}*/
/* */
