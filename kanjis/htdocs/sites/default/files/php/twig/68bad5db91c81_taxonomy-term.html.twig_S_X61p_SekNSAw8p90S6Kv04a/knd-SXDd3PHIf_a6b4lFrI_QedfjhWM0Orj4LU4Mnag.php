<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* themes/custom/bootstrap_subtheme/templates/taxonomy-term.html.twig */
class __TwigTemplate_5b5ee4be8b9e0ffedf190e0d7167ef75 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 29
        yield "
";
        // line 31
        $context["classes"] = [("term-id--" . CoreExtension::getAttribute($this->env, $this->source,         // line 32
($context["term"] ?? null), "id", [], "any", false, false, true, 32)), ("term-bundle--" . \Drupal\Component\Utility\Html::getClass(CoreExtension::getAttribute($this->env, $this->source,         // line 33
($context["term"] ?? null), "bundle", [], "any", false, false, true, 33))), ((("term-bundle--" . \Drupal\Component\Utility\Html::getClass(CoreExtension::getAttribute($this->env, $this->source,         // line 34
($context["term"] ?? null), "bundle", [], "any", false, false, true, 34))) . "--term-") . \Drupal\Component\Utility\Html::getClass(CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "label", [], "any", false, false, true, 34))), (((($tmp =         // line 35
($context["roottype"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (("root-type-" . \Drupal\Component\Utility\Html::getClass(($context["roottype"] ?? null)))) : ("")), (((($tmp =         // line 36
($context["weight"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (("weight-" . ($context["weight"] ?? null))) : (""))];
        // line 40
        $context["offset"] = (((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "field_offset", [], "any", false, false, true, 40), "value", [], "any", false, false, true, 40)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((("left:" . CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "field_offset", [], "any", false, false, true, 40), "value", [], "any", false, false, true, 40)) . "mm")) : (""));
        // line 43
        $context["faclass"] = (((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "field_fa_icon", [], "any", false, false, true, 43), "value", [], "any", false, false, true, 43)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "field_fa_icon", [], "any", false, false, true, 43), "value", [], "any", false, false, true, 43)) : (""));
        // line 45
        yield "

<span 
  ";
        // line 48
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 48), "html", null, true);
        yield "
  style=\"background-color:";
        // line 49
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["term"] ?? null), "field_color", [], "any", false, false, true, 49), "value", [], "any", false, false, true, 49), "html", null, true);
        yield "; ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["offset"] ?? null), "html", null, true);
        yield "\"
  >
    <i class=\"";
        // line 51
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["faclass"] ?? null), "html", null, true);
        yield "\"></i>
</span>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["term", "roottype", "weight", "attributes"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/bootstrap_subtheme/templates/taxonomy-term.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  74 => 51,  67 => 49,  63 => 48,  58 => 45,  56 => 43,  54 => 40,  52 => 36,  51 => 35,  50 => 34,  49 => 33,  48 => 32,  47 => 31,  44 => 29,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/bootstrap_subtheme/templates/taxonomy-term.html.twig", "C:\\Users\\ioPan\\Dev\\kanjiCards\\kanjis\\web\\themes\\custom\\bootstrap_subtheme\\templates\\taxonomy-term.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 31];
        static $filters = ["clean_class" => 33, "escape" => 48];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set'],
                ['clean_class', 'escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
